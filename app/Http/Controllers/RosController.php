<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\BusinessLocation;
use App\Transaction;
use App\TransactionSellLinesPurchaseLines;
use App\PurchaseLine;
use App\Ros;
use App\RosProduct;

use App\Utils\ProductUtil;
use App\Utils\TransactionUtil;
use App\Utils\ModuleUtil;

use Datatables;
use DB;

class RosController extends Controller
{

    /**
     * All Utils instance.
     *
     */
    protected $productUtil;
    protected $transactionUtil;
    protected $moduleUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(ProductUtil $productUtil, TransactionUtil $transactionUtil, ModuleUtil $moduleUtil)
    {
        $this->productUtil = $productUtil;
        $this->transactionUtil = $transactionUtil;
        $this->moduleUtil = $moduleUtil;
    }

    public function index()
    {
    	$business_id = request()->session()->get('user.business_id');

	    $user_id = request()->session()->get('user.id');

	    $requested_stocks = Ros::where('business_id', $business_id)
	    					->where('requested_by', $user_id)
	    					->get();

    	return view('request_stock.index', compact('requested_stocks'));
    }

    public function requested_stock()
    {
    	$business_id = request()->session()->get('user.business_id');

	    $user_id = request()->session()->get('user.id');

	    $permitted_locations = auth()->user()->permitted_locations();

        if($permitted_locations == "all")
        {
        	$bl = BusinessLocation::where('business_id', $business_id)
        							->pluck('id');

        	$business_locations = BusinessLocation::where('business_id', $business_id)
        							->whereIn('id', $bl)
        							->pluck('id');
        }
        else
        {
        	$business_locations = BusinessLocation::where('business_id', $business_id)
        							->whereIn('id', $permitted_locations)
        							->pluck('id');
        }

	    $requested_stocks = Ros::where('business_id', $business_id)
	    					->whereIn('to_id', $business_locations)
	    					->get();

    	return view('request_stock.requested_stock', compact('requested_stocks'));
    }

    public function createRequestStock()
    {
    	if (!auth()->user()->can('product.view')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        $assigned_locations = BusinessLocation::forDropdown($business_id);

        $permitted_locations = auth()->user()->permitted_locations();

        if($permitted_locations == "all")
        {
        	$bl = BusinessLocation::where('business_id', $business_id)
        							->pluck('id');

        	$business_locations = BusinessLocation::where('business_id', $business_id)
        							->whereIn('id', $bl)
        							->pluck('name', 'id');
        }
        else
        {
        	$business_locations = BusinessLocation::where('business_id', $business_id)
        							->whereNotIn('id', $permitted_locations)
        							->pluck('name', 'id');
        }

        

        							//return $business_locations;
        return view('request_stock.create')
                ->with(compact('assigned_locations', 'business_locations'));
    }

    public function storeRequestStock(Request $request)
    {
    	try {

	    	$business_id = $request->session()->get('user.business_id');

	    	$user_id = $request->session()->get('user.id');

	    	$ros = Ros::create([
	    		'business_id' => $business_id,
	    		'from_id' => $request->transfer_location_id,
	    		'to_id' => $request->location_id,
	    		'request_date' => $this->productUtil->uf_date($request->transaction_date),
	    		'status' => 'pending',
	    		'requested_by' => $user_id,
	    	]);

	    	$products = $request->input('products');

	    	if (!empty($products)) {
	                foreach ($products as $product) {

	                	if(!empty($product['lot_no_line_id'])) {
	                		$purchase_line_id = $product['lot_no_line_id'];
	                	}
	                	else
	                	{
	                		$purchase_line_id = NULL;
	                	}

	                	RosProduct::create([
				    		'ros_id' => $ros->id,
				    		'product_id' => $product['product_id'],
	                        'variation_id' => $product['variation_id'],
	                        'quantity' => $this->productUtil->num_uf($product['quantity']),
				    		'purchase_line_id' => $purchase_line_id,
				    	]);
	                }
	        }

	        $output = ['success' => 1,
                            'msg' => "Requested successfully"
                        ];

	    } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => 0,
                            'msg' => $e->getMessage()
                        ];
        }

        return redirect('request-stock')->with('status', $output);
    }

    public function editRequestStock($ros_id)
    {
    	if (!auth()->user()->can('product.view')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        $ros = Ros::findOrFail($ros_id);

        $ros_products = RosProduct::where('ros_id', $ros->id)
        						->leftJoin('products', 'products.id', '=', 'ros_products.product_id')
        						->leftJoin('variations', 'variations.id', '=', 'ros_products.variation_id')
				                ->leftJoin('units', 'products.unit_id', '=', 'units.id')
				                ->select('ros_products.id',
				                	'products.id as product_id',
				                    'products.name as product_name',
				                    'products.type',
				                    'units.short_name as unit',
				                    'units.allow_decimal as unit_allow_decimal',
				                    'products.sku',
				                    'products.enable_stock',
				                    'variations.id as variation_id',
				                	'variations.sub_sku',
				                	'ros_products.quantity',
				                	DB::raw("(SELECT purchase_price_inc_tax FROM purchase_lines WHERE 
                        variation_id=variations.id ORDER BY id DESC LIMIT 1) as last_purchased_price"))
				                ->toBase()
				                ->get();
        
        $assigned_locations = BusinessLocation::where('id', $ros->from_id)
        							->pluck('name', 'id');

       	$business_locations = BusinessLocation::where('id', $ros->to_id)
        							->pluck('name', 'id');

        //return $ros_products;
        							//return $business_locations;
        return view('request_stock.edit')
                ->with(compact('ros', 'ros_products', 'assigned_locations', 'business_locations'));
    }

    public function updateRequestStock(Request $request, $ros_id)
    {
    	try {
            
            $status = $request->status;
            $business_id = $request->session()->get('user.business_id');
            $user_id = $request->session()->get('user.id');

            //return $status;

            if($status == "approved")
            {

            	//Check if subscribed or not
	            if (!$this->moduleUtil->isSubscribed($business_id)) {
	                return $this->moduleUtil->expiredResponse(action('StockTransferController@index'));
	            }

	            DB::beginTransaction();
	            
	            $input_data = $request->only([ 'location_id', 'ref_no', 'transaction_date', 'final_total']);
	            
	            

	            $input_data['final_total'] = $this->productUtil->num_uf($input_data['final_total']);
	            $input_data['total_before_tax'] = $input_data['final_total'];

	            $input_data['type'] = 'sell_transfer';
	            $input_data['business_id'] = $business_id;
	            $input_data['created_by'] = $user_id;
	            $input_data['transaction_date'] = $this->productUtil->uf_date($input_data['transaction_date']);
	            $input_data['status'] = 'final';
	            $input_data['payment_status'] = 'paid';

	            //Update reference count
	            $ref_count = $this->productUtil->setAndGetReferenceCount('stock_transfer');
	            //Generate reference number
	            if (empty($input_data['ref_no'])) {
	                $input_data['ref_no'] = $this->productUtil->generateReferenceNumber('stock_transfer', $ref_count);
	            }

	            $products = $request->input('products');
	            $sell_lines = [];
	            $purchase_lines = [];

	            if (!empty($products)) {
	                foreach ($products as $product) {
	                    $sell_line_arr = [
	                                'product_id' => $product['product_id'],
	                                'variation_id' => $product['variation_id'],
	                                'quantity' => $this->productUtil->num_uf($product['quantity']),
	                                'item_tax' => 0,
	                                'tax_id' => null];

	                    $purchase_line_arr = $sell_line_arr;
	                    $sell_line_arr['unit_price'] = $this->productUtil->num_uf($product['unit_price']);
	                    $sell_line_arr['unit_price_inc_tax'] = $sell_line_arr['unit_price'];

	                    $purchase_line_arr['purchase_price'] = $sell_line_arr['unit_price'];
	                    $purchase_line_arr['purchase_price_inc_tax'] = $sell_line_arr['unit_price'];

	                    if (!empty($product['lot_no_line_id'])) {
	                        //Add lot_no_line_id to sell line
	                        $sell_line_arr['lot_no_line_id'] = $product['lot_no_line_id'];

	                        //Copy lot number and expiry date to purchase line
	                        $lot_details = PurchaseLine::find($product['lot_no_line_id']);
	                        $purchase_line_arr['lot_number'] = $lot_details->lot_number;
	                        $purchase_line_arr['mfg_date'] = $lot_details->mfg_date;
	                        $purchase_line_arr['exp_date'] = $lot_details->exp_date;
	                    }

	                    $sell_lines[] = $sell_line_arr;
	                    $purchase_lines[] = $purchase_line_arr;
	                }
	            }

	            //Create Sell Transfer transaction
	            $sell_transfer = Transaction::create($input_data);

	            //Create Purchase Transfer at transfer location
	            $input_data['type'] = 'purchase_transfer';
	            $input_data['status'] = 'received';
	            $input_data['location_id'] = $request->input('transfer_location_id');
	            $input_data['transfer_parent_id'] = $sell_transfer->id;

	            $purchase_transfer = Transaction::create($input_data);

	            //Sell Product from first location
	            if (!empty($sell_lines)) {
	                $this->transactionUtil->createOrUpdateSellLines($sell_transfer,$input_data['transaction_date'], $sell_lines, $input_data['location_id']);
	            }

	            //Purchase product in second location
	            if (!empty($purchase_lines)) {
	                $purchase_transfer->purchase_lines()->createMany($purchase_lines);
	            }

	            //Decrease product stock from sell location
	            //And increase product stock at purchase location
	            foreach ($products as $product) {
	                if ($product['enable_stock']) {
	                    $this->productUtil->decreaseProductQuantity(
	                        $product['product_id'],
	                        $product['variation_id'],
	                        $sell_transfer->location_id,
	                        $this->productUtil->num_uf($product['quantity'])
	                    );

	                    $this->productUtil->updateProductQuantity(
	                        $purchase_transfer->location_id,
	                        $product['product_id'],
	                        $product['variation_id'],
	                        $product['quantity']
	                    );
	                }
	            }

	            //Adjust stock over selling if found
	            $this->productUtil->adjustStockOverSelling($purchase_transfer);

	            //Map sell lines with purchase lines
	            $business = ['id' => $business_id,
	                        'accounting_method' => $request->session()->get('business.accounting_method'),
	                        'location_id' => $sell_transfer->location_id
	                    ];
	            $this->transactionUtil->mapPurchaseSell($business, $sell_transfer->sell_lines, 'purchase');

	            $ros = Ros::findOrFail($ros_id);
	           	$ros->status = $status;
	            $ros->approved_by = $user_id;
	            $ros->save();

	            $output = ['success' => 1,
	                            'msg' => __('lang_v1.stock_transfer_added_successfully')
	                        ];

	             DB::commit();
            }
            else
            {
            	$ros = Ros::findOrFail($ros_id);
	            $ros->status = $status;
	            $ros->rejected_by = $user_id;
	            $ros->save();
              
              	$output = ['success' => 0,
	                            'msg' => __('Request rejected successfully')
	                        ];
            }

            

           
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => 0,
                            'msg' => $e->getMessage()
                        ];
        }

        return redirect()->route('requested-stock')->with('status', $output);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function viewRequestProducts($id)
    {
        if (!auth()->user()->can('product.view')) {
            abort(403, 'Unauthorized action.');
        }

        $ros = Ros::findOrFail($id);

        $stock_adjustment_details = RosProduct::where('ros_id', $ros->id)
        						->leftJoin('products', 'products.id', '=', 'ros_products.product_id')
        						->leftJoin('variations', 'variations.id', '=', 'ros_products.variation_id')
				                ->leftJoin('units', 'products.unit_id', '=', 'units.id')
				                ->select('ros_products.id',
				                	'products.id as product_id',
				                    'products.name as product_name',
				                    'products.type',
				                    'units.short_name as unit',
				                    'units.allow_decimal as unit_allow_decimal',
				                    'products.sku',
				                    'products.enable_stock',
				                    'variations.id as variation_id',
				                	'variations.sub_sku',
				                	'ros_products.quantity',
				                	DB::raw("(SELECT purchase_price_inc_tax FROM purchase_lines WHERE 
                        variation_id=variations.id ORDER BY id DESC LIMIT 1) as last_purchased_price"))
				                ->toBase()
				                ->get();

        // $stock_adjustment_details = RosProduct::
        //             join(
        //                 'transaction_sell_lines as sl',
        //                 'sl.transaction_id',
        //                 '=',
        //                 'transactions.id'
        //             )
        //             ->join('products as p', 'sl.product_id', '=', 'p.id')
        //             ->join('variations as v', 'sl.variation_id', '=', 'v.id')
        //             ->join('product_variations as pv', 'v.product_variation_id', '=', 'pv.id')
        //             ->where('transactions.id', $id)
        //             ->where('transactions.type', 'sell_transfer')
        //             ->leftjoin('purchase_lines as pl', 'sl.lot_no_line_id', '=', 'pl.id')
        //             ->select(
        //                 'p.name as product',
        //                 'p.type as type',
        //                 'pv.name as product_variation',
        //                 'v.name as variation',
        //                 'v.sub_sku',
        //                 'sl.quantity',
        //                 'sl.unit_price',
        //                 'pl.lot_number',
        //                 'pl.exp_date'
        //             )
        //             ->groupBy('sl.id')
        //             ->get();

        $lot_n_exp_enabled = false;
        if (request()->session()->get('business.enable_lot_number') == 1 || request()->session()->get('business.enable_product_expiry') == 1) {
            $lot_n_exp_enabled = true;
        }

        return view('request_stock.view')
                ->with(compact('stock_adjustment_details', 'lot_n_exp_enabled'));
    }
}
