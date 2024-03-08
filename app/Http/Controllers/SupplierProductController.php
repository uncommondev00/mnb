<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use App\Product;
use App\SupplierProduct;
use DB;

class SupplierProductController extends Controller
{
    public function products($supplier_id)
    {
    	if (!auth()->user()->can('supplier.view')) {
            abort(403, 'Unauthorized action.');
        }

    	$business_id = request()->session()->get('user.business_id');

    	$supplier = Contact::where('contacts.business_id', $business_id)
    				->where('id', $supplier_id)
                    ->onlySuppliers()
                    ->select('id', 'name')
                    ->first();

        $added_product_array = SupplierProduct::where('business_id', $business_id)
        									  ->where('contact_id', $supplier_id)
        									  ->pluck('product_id')
        									  ->toArray();

    	$products = Product::leftJoin('brands', 'products.brand_id', '=', 'brands.id')
                ->leftJoin('units', 'products.unit_id', '=', 'units.id')
                ->leftJoin('categories as c1', 'products.category_id', '=', 'c1.id')
                ->where('products.business_id', $business_id)
                ->whereNotIn('products.id', $added_product_array)
                ->select('products.id',
                    'products.name as product',
                    'products.type',
                    'c1.name as category',
                    'units.actual_name as unit',
                    'brands.name as brand',
                    'products.sku')
                ->toBase()
                ->get();

        $added_products = SupplierProduct::leftJoin('products', 'products.id', '=', 'supplier_products.product_id')
        		->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
                ->leftJoin('units', 'products.unit_id', '=', 'units.id')
                ->leftJoin('categories as c1', 'products.category_id', '=', 'c1.id')
                ->where('supplier_products.business_id', $business_id)
                ->where('supplier_products.contact_id', $supplier_id)
                ->select('supplier_products.id',
                    'products.name as product',
                    'products.type',
                    'c1.name as category',
                    'units.actual_name as unit',
                    'brands.name as brand',
                    'products.sku')
                ->toBase()
                ->get();

    	return view('supplier_products.index', compact('supplier_id', 'supplier','products', 'added_products'));
    }

    public function massAddProducts($supplier_id,  Request $request)
    {
    	if (!auth()->user()->can('supplier.view')) {
            abort(403, 'Unauthorized action.');
        }

    	try {

            if (!empty($request->input('selected_products1'))) {
                $business_id = $request->session()->get('user.business_id');

                $selected_rows = explode(',', $request->input('selected_products1'));

                $products = Product::where('business_id', $business_id)
                                    ->whereIn('id', $selected_rows)
                                    ->get();

                DB::beginTransaction();

                foreach ($products as $product) {
                   
			        SupplierProduct::updateOrCreate(
					    ['business_id' => $business_id, 'contact_id' => $supplier_id, 'product_id' => $product->id]
					);

                }

                DB::commit();

                $output = ['success' => 1,
                            'msg' => __("Added successfully")
                        ];
            }
            else
            {
            	$output = ['success' => 0,
                            'msg' => __("No selected products")
                        ];
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => 0,
                            'msg' => __("Something went wrong. Please try again.")
                        ];
        }

        return redirect()->back()->with(['status' => $output]);
    }

    public function massRemoveProducts($supplier_id,  Request $request)
    {
    	if (!auth()->user()->can('supplier.view')) {
            abort(403, 'Unauthorized action.');
        }

    	try {

            if (!empty($request->input('selected_products2'))) {
                $business_id = $request->session()->get('user.business_id');

                $selected_rows = explode(',', $request->input('selected_products2'));

                $products = SupplierProduct::where('business_id', $business_id)
                                    ->whereIn('id', $selected_rows)
                                    ->delete();

           //      DB::beginTransaction();

           //      foreach ($products as $product) {
                   
			        // $supplier_product = SupplierProduct::findOrFail($product->id);


           //      }

           //      DB::commit();

                $output = ['success' => 1,
                            'msg' => __("Removed successfully")
                        ];
            }
            else
            {
            	$output = ['success' => 0,
                            'msg' => __("No selected products")
                        ];
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => 0,
                            'msg' => __("Something went wrong. Please try again.")
                        ];
        }

        return redirect()->back()->with(['status' => $output]);
    }

    public function viewSupplierProducts(Request $request)
    {
    	$business_id = $request->session()->get('user.business_id');

    	$supplier_id = $request->supplier_id;

    	$supplier = Contact::where('contacts.business_id', $business_id)
    				->where('id', $supplier_id)
                    ->onlySuppliers()
                    ->select('id', 'name')
                    ->first();

    	$added_products = SupplierProduct::leftJoin('products', 'products.id', '=', 'supplier_products.product_id')
        		->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
                ->leftJoin('units', 'products.unit_id', '=', 'units.id')
                ->leftJoin('categories as c1', 'products.category_id', '=', 'c1.id')
                ->leftJoin('variations', 'products.id', '=', 'variations.product_id')
                ->where('supplier_products.business_id', $business_id)
                ->where('supplier_products.contact_id', $supplier_id)
                ->select('supplier_products.id',
                    'products.id as product_id',
                    'variations.id as variation_id',
                    'products.name as product',
                    'products.type',
                    'c1.name as category',
                    'units.actual_name as unit',
                    'brands.name as brand',
                    'products.sku')
                ->orderBy('products.sku', 'ASC')
                ->toBase()
                ->get();

    	return view('purchase.partials.supplier_product', compact('supplier', 'added_products'));
    }
}
