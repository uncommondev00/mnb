@extends('layouts.app')
@section('title', 'Edit Request Stock')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Request Stock</h1>
</section>

<!-- Main content -->
<section class="content no-print">
	{!! Form::open(['url' => route('update-request-stock',$ros->id), 'method' => 'put', 'id' => 'stock_request_form' ]) !!}
	<div class="box box-solid">
		<div class="box-body">
			<div class="row">
				<div class="col-sm-3">
					<div class="form-group">
						{!! Form::label('transaction_date', __('messages.date') . ':*') !!}
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							{!! Form::text('transaction_date', @format_date($ros->request_date), ['class' => 'form-control', 'readonly', 'required']); !!}
						</div>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						{!! Form::label('transfer_location_id', __('Request (From)').':*') !!}
						{!! Form::select('transfer_location_id', $assigned_locations, null, ['class' => 'form-control select2', 'required', 'id' => 'transfer_location_id']); !!}
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						{!! Form::label('location_id', __('Request (To)').':*') !!}
						{!! Form::select('location_id', $business_locations, null, ['class' => 'form-control select2',  'required', 'id' => 'location_id']); !!}
					</div>
				</div>

				<div class="col-sm-3">
					<div class="form-group">
						@php
							$status = ['approved'=>'Approved','reject'=>'Reject'];		
						@endphp
						{!! Form::label('status', __('Status').':*') !!}
						{!! Form::select('status', $status, null, ['class' => 'form-control select2',  'required', 'id' => 'status']); !!}
					</div>
				</div>
				
			</div>
		</div>
	</div> <!--box end-->
	<div class="box box-solid">
		
		<div class="box-body">
			
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<input type="hidden" id="product_row_index" value="0">
					
					<div class="table-responsive">
					<table class="table table-bordered table-striped table-condensed" id="stock_request_product_table">
						<thead>
							<tr>
								<th class="col-sm-4 text-center">	
									@lang('sale.product')
								</th>
								<th class="col-sm-2 text-center">
									@lang('sale.qty')
								</th>
								<th class="col-sm-2 text-center">
									@lang('sale.unit_price')
								</th>
								<th class="col-sm-2 text-center">
									@lang('sale.subtotal')
								</th>
								
							</tr>
						</thead>
						<tbody>
							@php
							$total = 0;
							@endphp
							@foreach($ros_products as $product)
								<tr class="product_row">
								    <td>
								        {{$product->product_name}}
								        <br/>
								        {{$product->sub_sku}}

								        @if( session()->get('business.enable_lot_number') == 1 || session()->get('business.enable_product_expiry') == 1)
								        @php
								            $lot_enabled = session()->get('business.enable_lot_number');
								            $exp_enabled = session()->get('business.enable_product_expiry');
								            $lot_no_line_id = '';
								            if(!empty($product->lot_no_line_id)){
								                $lot_no_line_id = $product->lot_no_line_id;
								            }
								        @endphp
								        @if(!empty($product->lot_numbers))
								            <select class="form-control lot_number" name="products[{{$product->id}}][lot_no_line_id]">
								                <option value="">@lang('lang_v1.lot_n_expiry')</option>
								                @foreach($product->lot_numbers as $lot_number)
								                    @php
								                        $selected = "";
								                        if($lot_number->purchase_line_id == $lot_no_line_id){
								                            $selected = "selected";

								                            $max_qty_rule = $lot_number->qty_available;
								                            $max_qty_msg = __('lang_v1.quantity_error_msg_in_lot', ['qty'=> $lot_number->qty_formated, 'unit' => $product->unit  ]);
								                        }

								                        $expiry_text = '';
								                        if($exp_enabled == 1 && !empty($lot_number->exp_date)){
								                            if( \Carbon::now()->gt(\Carbon::createFromFormat('Y-m-d', $lot_number->exp_date)) ){
								                                $expiry_text = '(' . __('report.expired') . ')';
								                            }
								                        }
								                    @endphp
								                    <option value="{{$lot_number->purchase_line_id}}" data-qty_available="{{$lot_number->qty_available}}" data-msg-max="@lang('lang_v1.quantity_error_msg_in_lot', ['qty'=> $lot_number->qty_formated, 'unit' => $product->unit  ])" {{$selected}}>@if(!empty($lot_number->lot_number) && $lot_enabled == 1){{$lot_number->lot_number}} @endif @if($lot_enabled == 1 && $exp_enabled == 1) - @endif @if($exp_enabled == 1 && !empty($lot_number->exp_date)) @lang('product.exp_date'): {{@format_date($lot_number->exp_date)}} @endif {{$expiry_text}}</option>
								                @endforeach
								            </select>
								        @endif
								    @endif
								    </td>
								    <td>
								        {{-- If edit then transaction sell lines will be present --}}
								        @if(!empty($product->transaction_sell_lines_id))
								            <input type="hidden" name="products[{{$product->id}}][transaction_sell_lines_id]" class="form-control" value="{{$product->transaction_sell_lines_id}}">
								        @endif

								        <input type="hidden" name="products[{{$product->id}}][product_id]" class="form-control product_id" value="{{$product->product_id}}">

								        <input type="hidden" value="{{$product->variation_id}}" 
								            name="products[{{$product->id}}][variation_id]">

								        <input type="hidden" value="{{$product->enable_stock}}" 
								            name="products[{{$product->id}}][enable_stock]">
								        
								        @if(empty($product->quantity_ordered))
								            @php
								                $product->quantity_ordered = 1;
								                
								                $qty_available = App\VariationLocationDetails::where('product_id', $product->product_id)
								                											->where('variation_id', $product->variation_id)
								                											->where('location_id', $ros->to_id)
								                											->sum('qty_available');

								                $formatted_qty_available = number_format($qty_available,2);
								            @endphp
								        @endif

								        <input type="text" class="form-control product_quantity input_number input_quantity" value="{{@format_quantity($product->quantity)}}" name="products[{{$product->id}}][quantity]" 
								        @if($product->unit_allow_decimal == 1) data-decimal=1 @else data-rule-abs_digit="true" data-msg-abs_digit="@lang('lang_v1.decimal_value_not_allowed')" data-decimal=0 @endif
								        data-rule-required="true" data-msg-required="@lang('validation.custom-messages.this_field_is_required')" @if($product->enable_stock) data-rule-max-value="{{$qty_available}}" data-msg-max-value="@lang('validation.custom-messages.quantity_not_available', ['qty'=> $formatted_qty_available, 'unit' => $product->unit  ])"
								        data-qty_available="{{$qty_available}}" 
								        data-msg_max_default="@lang('validation.custom-messages.quantity_not_available', ['qty'=> $formatted_qty_available, 'unit' => $product->unit  ])"
								         @endif >
								        {{$product->unit}}
								    </td>
								    <td>
								        <input type="text" name="products[{{$product->id}}][unit_price]" class="form-control product_unit_price input_number" value="{{@num_format($product->last_purchased_price)}}">
								    </td>
								    <td>
								        <input type="text" readonly name="products[{{$product->id}}][price]" class="form-control product_line_total" value="{{@num_format($product->quantity*$product->last_purchased_price)}}">
								    </td>

								    @php
								    	$total += $product->quantity*$product->last_purchased_price;
								    @endphp
								    
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<input type="hidden" id="total_amount" name="final_total" value="{{$total}}">
							<tr class="text-center"><td colspan="3"></td><td><div class="pull-right"><b>@lang('stock_adjustment.total_amount'):</b> <span id="total_adjustment">{{@num_format($total)}}</span></div></td></tr>
						</tfoot>
						
					</table>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<button type="submit" id="save_stock_transfer" class="btn btn-primary pull-right">@lang('messages.save')</button>
				</div>
			</div>
		</div>
	</div> <!--box end-->
	{!! Form::close() !!}

</section>
@stop
@section('javascript')
	<script src="{{ asset('js/stock_request.js?v=' . $asset_v) }}"></script>
@endsection

