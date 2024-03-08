<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use App\CustomerProductDiscount;
use App\Product;
use DB;

class CustomerProductDiscountController extends Controller
{
    public function create_customer_discount($product_id)
    {
    	$product = Product::findorFail($product_id);

    	$added_customers = CustomerProductDiscount::where('product_id', $product->id)
    												->pluck('customer_id');

    	$customers = Contact::where('type', 'customer')
    						->whereNotIn('id', $added_customers)
    						->pluck('name', 'id');

    	$customer_discounts = CustomerProductDiscount::where('product_id', $product->id)
    												->leftJoin('contacts', 'contacts.id', '=', 'customer_product_discounts.customer_id')
    												->select('customer_product_discounts.*', 'contacts.name')
    												->get();

    	return view('customer_product_discount.index', compact('product', 'customers', 'customer_discounts'));
    }

    public function store_customer_discount(Request $request, $product_id)
    {

    	try {

	    	CustomerProductDiscount::updateOrCreate(
						    ['customer_id' => $request->customer_id, 'product_id' => $product_id],
						    ['discount' => $request->discount]
						);

	    	$output = ['success' => 1,
                            'msg' => __("Added successfully")
                        ];

    	} catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => 0,
                            'msg' => __("Something went wrong. Please try again.")
                        ];
        }

        return redirect()->back()->with(['status' => $output]);
    }

    public function remove_customer_discount($cpd_id)
    {
    	$cpd = CustomerProductDiscount::findOrFail($cpd_id);

    	$product_id = $cpd->product_id;

    	$cpd->delete();

        $output = ['success' => 1,
                'msg' => __(" Removed successfully.")
            ];

        session()->flash('status', $output);

        return route('create-customer-discount', $product_id);
    }
}
