<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-body bg-gray disabled" style="margin-bottom: 0px !important">
				<table class="table table-condensed" 
					style="margin-bottom: 0px !important">
					<tbody>
					<tr>
						<td>
							<!--total quantity-->
							<div class="col-sm-1 col-xs-3 d-inline-table hide">
								<b>@lang('sale.item'):</b> 
								<br/>
								<span class="total_quantity">0</span>
							</div>
							
							<!--price total-->
							<div class="col-sm-2 col-xs-3 d-inline-table" style="font-size: 20px !important;">
								<b>@lang('sale.total'):</b> 
								<br/>
								<span class="price_total">0</span>
							</div>

							
							<!--Order tax button-->
							<div class="col-sm-2 col-xs-6 d-inline-table hide">

								<span class="@if($pos_settings['disable_order_tax'] != 0) hide @endif">

								<b>@lang('sale.order_tax')(+): @show_tooltip(__('tooltip.sale_tax'))</b>
								<br/>
								<i class="fa fa-pencil-square-o cursor-pointer" title="@lang('sale.edit_order_tax')" aria-hidden="true" data-toggle="modal" data-target="#posEditOrderTaxModal" id="pos-edit-tax" ></i> 
								<span id="order_tax">
									@if(empty($edit))
										0
									@else
										{{$transaction->tax_amount}}
									@endif
								</span>

								<input type="hidden" name="tax_rate_id" 
									id="tax_rate_id" 
									value="@if(empty($edit)) {{$business_details->default_sales_tax}} @else {{$transaction->tax_id}} @endif" 
									data-default="{{$business_details->default_sales_tax}}">

								<input type="hidden" name="tax_calculation_amount" id="tax_calculation_amount" 
									value="@if(empty($edit)) {{@num_format($business_details->tax_calculation_amount)}} @else {{@num_format(optional($transaction->tax)->amount)}} @endif" data-default="{{$business_details->tax_calculation_amount}}">

								</span>
							</div>
							
							<!-- shipping -->
							<div class="col-sm-2 col-xs-6 d-inline-table hide">

								<span class="@if($pos_settings['disable_discount'] != 0) hide @endif">

								<b>@lang('sale.shipping')(+): @show_tooltip(__('tooltip.shipping'))</b> 
								<br/>
								<i class="fa fa-pencil-square-o cursor-pointer"  title="@lang('sale.shipping')" aria-hidden="true" data-toggle="modal" data-target="#posShippingModal"></i>
								<span id="shipping_charges_amount">0</span>
								<input type="hidden" name="shipping_details" id="shipping_details" value="@if(empty($edit)){{""}}@else{{$transaction->shipping_details}}@endif" data-default="">

								<input type="hidden" name="shipping_charges" id="shipping_charges" value="@if(empty($edit)){{@num_format(0.00)}} @else{{@num_format($transaction->shipping_charges)}} @endif" data-default="0.00">

								</span>
							</div>

							<!--Total Payable-->
							<div class="col-sm-3 col-xs-12 d-inline-table" style="font-size: 20px !important;">
								<b>@lang('sale.total_payable'):</b>
								<br/>
								<input type="hidden" name="final_total" 
									id="final_total_input"  value=0 >
								<span id="total_payable" class="text-success lead text-bold">0</span>
								
							</div>

							<!--total quantity-->
							<div class="col-sm-1 col-xs-3 d-inline-table" style="font-size: 20px !important;">
								<b>@lang('sale.item'):</b> 
								<br/>
								<span class="total_quantity">0</span>
							</div>



							
							<!--cancel button-->
							<div class="col-sm-5 col-xs-12 d-inline-table">
								@if(empty($edit))
									<button type="button" class="btn btn-danger btn-flat btn-xs pull-right" id="pos-cancel" onclick="delete_cookie();">@lang('sale.cancel')</button>
								@else
									<button type="button" class="btn btn-danger btn-flat hide btn-xs pull-right" id="pos-delete">@lang('messages.delete')</button>
								@endif
							</div>
						</td>
					</tr>

					</tbody>
				</table>

				<!-- Button to perform various actions -->
				<div class="row">
					
				</div>
			</div>
		</div>
	</div>
</div>

@if(isset($transaction))
	@include('sale_pos.partials.edit_discount_modal', ['sales_discount' => $transaction->discount_amount, 'discount_type' => $transaction->discount_type])
@else
	@include('sale_pos.partials.edit_discount_modal', ['sales_discount' => $business_details->default_sales_discount, 'discount_type' => 'percentage'])
@endif

@if(isset($transaction))
	@include('sale_pos.partials.add_discount_modal', ['sales_discount' => $transaction->discount_amount, 'discount_type' => $transaction->discount_type])
@else
	@include('sale_pos.partials.add_discount_modal', ['sales_discount' => $business_details->default_sales_discount, 'discount_type' => 'percentage'])
@endif

@if(isset($transaction))
	@include('sale_pos.partials.edit_order_tax_modal', ['selected_tax' => $transaction->tax_id])
@else
	@include('sale_pos.partials.edit_order_tax_modal', ['selected_tax' => $business_details->default_sales_tax])
@endif

@if(isset($transaction))
	@include('sale_pos.partials.edit_shipping_modal', ['shipping_charges' => $transaction->shipping_charges, 'shipping_details' => $transaction->shipping_details])
@else
	@include('sale_pos.partials.edit_shipping_modal', ['shipping_charges' => '0.00', 'shipping_details' => ''])
@endif