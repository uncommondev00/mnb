<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\TaxRate;
use App\Transaction;
use App\BusinessLocation;
use App\TransactionSellLine;
use App\User;
use App\CustomerGroup;
use App\SellingPriceGroup;
use App\Contact;
use App\VoidTransaction;
use Yajra\DataTables\Facades\DataTables;
use DB;

use App\Utils\ContactUtil;
use App\Utils\BusinessUtil;
use App\Utils\TransactionUtil;
use App\Utils\ModuleUtil;
use App\Utils\ProductUtil;

class VoidTransactionController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $contactUtil;
    protected $businessUtil;
    protected $transactionUtil;
    protected $productUtil;


    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(ContactUtil $contactUtil, BusinessUtil $businessUtil, TransactionUtil $transactionUtil, ModuleUtil $moduleUtil, ProductUtil $productUtil)
    {
        $this->contactUtil = $contactUtil;
        $this->businessUtil = $businessUtil;
        $this->transactionUtil = $transactionUtil;
        $this->moduleUtil = $moduleUtil;
        $this->productUtil = $productUtil;

        $this->dummyPaymentLine = ['method' => 'cash', 'amount' => 0, 'note' => '', 'card_transaction_number' => '', 'card_number' => '', 'card_type' => '', 'card_holder_name' => '', 'card_month' => '', 'card_year' => '', 'card_security' => '', 'cheque_number' => '', 'bank_account_number' => '',
        'is_return' => 0, 'transaction_no' => ''];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (!auth()->user()->can('sell.view')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $is_woocommerce = $this->moduleUtil->isModuleInstalled('Woocommerce');

        
        $ipAddress=$_SERVER['REMOTE_ADDR'];

                //echo "$ipAddress - ";
        $macAddr="";

                #run the external command, break output into lines
        $arp=`arp -a $ipAddress`;
        $lines=explode("\n", $arp);

                #look for the output line describing our IP address
                foreach($lines as $line)
                {
                   $cols=preg_split('/\s+/', trim($line));
                   if ($cols[0]==$ipAddress)
                   {
                      
                   	$macAddr = $cols[1];
                   }

                }
            
        //$mac = substr(exec('getmac'), 0, 17);
        //$mac = echo substr(exec('getmac'),0,17);
        if (request()->ajax()) {
            $with = [];

            $sells = VoidTransaction::leftJoin('contacts', 'void_transactions.contact_id', '=', 'contacts.id')
                ->leftJoin('transaction_payments as tp', 'void_transactions.id', '=', 'tp.transaction_id')
                ->join(
                    'business_locations AS bl',
                    'void_transactions.location_id',
                    '=',
                    'bl.id'
                )
                ->leftJoin(
                    'void_transactions AS SR',
                    'void_transactions.id',
                    '=',
                    'SR.return_parent_id'
                )
                ->where('void_transactions.business_id', $business_id)
                ->where('void_transactions.mac_address', $macAddr)
                ->where('void_transactions.type', 'sell')
                ->where('void_transactions.status', 'final')
                ->select(
                    'void_transactions.id',
                    'void_transactions.ip_address',
                    'void_transactions.mac_address',
                    'void_transactions.transaction_date',
                    'void_transactions.is_direct_sale',
                    'void_transactions.invoice_no',
                    'contacts.name',
                    'void_transactions.payment_status',
                    'void_transactions.final_total',
                    'void_transactions.tax_amount',
                    'void_transactions.discount_amount',
                    'void_transactions.discount_type',
                    'void_transactions.total_before_tax',
                    DB::raw('SUM(IF(tp.is_return = 1,-1*tp.amount,tp.amount)) as total_paid'),
                    'bl.name as business_location',
                    DB::raw('COUNT(SR.id) as return_exists'),
                    DB::raw('(SELECT SUM(TP2.amount) FROM transaction_payments AS TP2 WHERE
                        TP2.transaction_id=SR.id ) as return_paid'),
                    DB::raw('COALESCE(SR.final_total, 0) as amount_return'),
                    'SR.id as return_transaction_id'
                );



            $permitted_locations = auth()->user()->permitted_locations();
            if ($permitted_locations != 'all') {
                $sells->whereIn('void_transactions.location_id', $permitted_locations);
            }

            //Add condition for created_by,used in sales representative sales report
            if (request()->has('created_by')) {
                $created_by = request()->get('created_by');
                if (!empty($created_by)) {
                    $sells->where('void_transactions.created_by', $created_by);
                }
            }

            if (!empty(request()->input('payment_status'))) {
                $sells->where('void_transactions.payment_status', request()->input('payment_status'));
            }

            //Add condition for location,used in sales representative expense report
            if (request()->has('location_id')) {
                $location_id = request()->get('location_id');
                if (!empty($location_id)) {
                    $sells->where('void_transactions.location_id', $location_id);
                }
            }

            if (!empty(request()->customer_id)) {
                $customer_id = request()->customer_id;
                $sells->where('contacts.id', $customer_id);
            }
            if (!empty(request()->start_date) && !empty(request()->end_date)) {
                $start = request()->start_date;
                $end =  request()->end_date;
                $sells->whereDate('void_transactions.transaction_date', '>=', $start)
                            ->whereDate('void_transactions.transaction_date', '<=', $end);
            }

            //Check is_direct sell
            if (request()->has('is_direct_sale')) {
                $is_direct_sale = request()->is_direct_sale;
                if ($is_direct_sale == 0) {
                    $sells->where('void_transactions.is_direct_sale', 0);
                    $sells->whereNull('void_transactions.sub_type');
                }
            }

            //Add condition for commission_agent,used in sales representative sales with commission report
            if (request()->has('commission_agent')) {
                $commission_agent = request()->get('commission_agent');
                if (!empty($commission_agent)) {
                    $sells->where('void_transactions.commission_agent', $commission_agent);
                }
            }

            if ($is_woocommerce) {
                $sells->addSelect('void_transactions.woocommerce_order_id');
                if (request()->only_woocommerce_sells) {
                    $sells->whereNotNull('void_transactions.woocommerce_order_id');
                }
            }

            if (!empty(request()->list_for) && request()->list_for == 'service_staff_report') {
                $sells->whereNotNull('void_transactions.res_waiter_id');
                $sells->leftJoin('users as ss', 'ss.id', '=', 'void_transactions.res_waiter_id');
                $sells->addSelect(
                    DB::raw('CONCAT(COALESCE(ss.first_name, ""), COALESCE(ss.last_name, "")) as service_staff')
                );
            }

            if (!empty(request()->res_waiter_id)) {
                $sells->where('void_transactions.res_waiter_id', request()->res_waiter_id);
            }

            if (!empty(request()->input('sub_type'))) {
                $sells->where('void_transactions.sub_type', request()->input('sub_type'));
            }

            $sells->groupBy('void_transactions.id');

            if (!empty(request()->suspended)) {
                $is_tables_enabled = $this->transactionUtil->isModuleEnabled('tables');
                $is_service_staff_enabled = $this->transactionUtil->isModuleEnabled('service_staff');
                $with = ['sell_lines'];

                if ($is_tables_enabled) {
                    $with[] = 'table';
                }

                if ($is_service_staff_enabled) {
                    $with[] = 'service_staff';
                }

                $sales = $sells->where('void_transactions.is_suspend', 1)
                            ->with($with)
                            ->addSelect('void_transactions.is_suspend', 'void_transactions.res_table_id', 'void_transactions.res_waiter_id', 'void_transactions.additional_notes')
                            ->get();

                return view('sale_pos.partials.suspended_sales_modal')->with(compact('sales', 'is_tables_enabled', 'is_service_staff_enabled'));
            }
            if (!empty($with)) {
                $sells->with($with);
            }

            //$business_details = $this->businessUtil->getDetails($business_id);
            if ($this->businessUtil->isModuleEnabled('subscription')) {
                $sells->addSelect('void_transactions.is_recurring', 'void_transactions.recur_parent_id');
            }

            $datatable = Datatables::of($sells)
                
                ->removeColumn('id')
                ->editColumn(
                    'final_total',
                    '<span class="display_currency final-total" data-currency_symbol="true" data-orig-value="{{$final_total }}">{{$final_total}}</span>'
                )
                ->editColumn(
                    'ip',
                    function ($row) {
                        $ip = !empty($row->ip_address) ? $row->ip_address : "server";

                        return '<span>' . $ip . '</span>';
                    }
                )
                 ->editColumn(
                    'mac',
                    function ($row) {
                        $mac = !empty($row->mac_address) ? $row->mac_address : "server";

                        return '<span>' . $mac . '</span>';
                    }
                )
             
                ->editColumn('transaction_date', '{{@format_date($transaction_date)}}')

                ->editColumn(
                    'payment_status',
                    '<div class="payment-status-label no-print" data-orig-value="{{$payment_status}}" data-status-name="{{__(\'lang_v1.\' . $payment_status)}}"><span class="label bg-red @payment_status($payment_status)">{{__(\'lang_v1.\' . $payment_status)}}
                        </span></div>
                        <span class="print_section">{{__(\'lang_v1.\' . $payment_status)}}</span>
                        '
                )
                 ->editColumn('invoice_no', function ($row) {
                     $invoice_no = $row->invoice_no;
                     if (!empty($row->woocommerce_order_id)) {
                         $invoice_no .= ' <i class="fa fa-wordpress text-primary no-print" title="' . __('lang_v1.synced_from_woocommerce') . '"></i>';
                     }
                     if (!empty($row->return_exists)) {
                         $invoice_no .= ' &nbsp;<small class="label bg-red label-round no-print" title="' . __('lang_v1.some_qty_returned_from_sell') .'"><i class="fa fa-undo"></i></small>';
                     }

                     if (!empty($row->is_recurring)) {
                         $invoice_no .= ' &nbsp;<small class="label bg-red label-round no-print" title="' . __('lang_v1.subscribed_invoice') .'"><i class="fa fa-recycle"></i></small>';
                     }

                     if (!empty($row->recur_parent_id)) {
                         $invoice_no .= ' &nbsp;<small class="label bg-info label-round no-print" title="' . __('lang_v1.subscription_invoice') .'"><i class="fa fa-recycle"></i></small>';
                     }

                     return $invoice_no;
                 })
                ->setRowAttr([
                    'data-href' => function ($row) {
                        if (auth()->user()->can("sell.view")) {
                            //return  action('SellController@show', [$row->id]) ;
                        } else {
                            return '';
                        }
                    }]);

            $rawColumns = ['final_total', 'payment_status', 'invoice_no', 'mac', 'ip'];
                
            return $datatable->rawColumns($rawColumns)
                      ->make(true);
        }

        $business_locations = BusinessLocation::forDropdown($business_id, false);
        $customers = Contact::customersDropdown($business_id, false);

        return view('void.index')->with(compact('business_locations', 'customers', 'is_woocommerce'));
    }

  
}
