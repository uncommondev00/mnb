<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">{{$product->product_name}} - {{$product->sub_sku}}</h4>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="form-group col-xs-12 @if(!auth()->user()->can('edit_product_price_from_sale_screen')) hide @endif">
					<label>@lang('sale.unit_price')</label>
						<input type="text" name="products[{{$row_count}}][unit_price]" class="form-control pos_unit_price input_number mousetrap" value="{{@num_format(!empty($product->unit_price_before_discount) ? $product->unit_price_before_discount : $product->default_sell_price)}}" readonly>
				</div>

				@php
				$dis_val = 0;

				

				if (isset($_COOKIE['discount'])) {
					$main_discount =  $_COOKIE["discount"];
				} else {
					$main_discount = 0;
				}

				if (isset($_GET['name'])) {
						$cokie =  $_GET['name'];
						
						if (isset($_COOKIE[$cokie])) {
						$coc = $_COOKIE[$cokie];
						$dis_val = $coc;
						}else{
						$coc = 0;
						$dis_val = $coc;	
						}
					}else{
						$dis_val = $main_discount;
					}

				//$coc = $_COOKIE[$cokie];


				//echo $dis_val;

				
				//echo $coc;

				
				$item_discount = $dis_val;
				
					$discount_type = !empty($product->line_discount_type) ? $product->line_discount_type : 'percentage';


					$discount_amount = !empty($product->line_discount_amount) ? $product->line_discount_amount : $item_discount;
					
					if(!empty($discount)) {
						$discount_type = $discount->discount_type;
						$discount_amount = $discount->discount_amount;
					}
				@endphp

				@if(!empty($discount))
					{!! Form::hidden("products[$row_count][discount_id]", $discount->id); !!}
				@endif
				<div class="form-group col-xs-12 col-sm-6 hide @if(!auth()->user()->can('edit_product_discount_from_sale_screen')) hide @endif">
					<label>@lang('sale.discount_type')</label>
						{!! Form::select("products[$row_count][line_discount_type]", [ 'percentage' => __('lang_v1.percentage'), 'fixed' => __('lang_v1.fixed') ], $discount_type , ['class' => 'form-control row_discount_type', 'visible' => false]) ;   !!}
					@if(!empty($discount))
						<p class="help-block">{!! __('lang_v1.applied_discount_text', ['discount_name' => $discount->name, 'starts_at' => $discount->formated_starts_at, 'ends_at' => $discount->formated_ends_at]) !!}</p>
					@endif
				</div>
				<div class="form-group col-xs-12 col-sm-6 @if(!auth()->user()->can('edit_product_discount_from_sale_screen')) hide @endif">
					
					
					<label>@lang('sale.discount_amount')</label>
						{!! Form::text("products[$row_count][line_discount_amount]", @num_format($discount_amount), ['class' => 'form-control input_number row_discount_amount', 'id' => 'item_discount', 'readonly']); !!}
				</div>
				<div class="form-group col-xs-12 {{$hide_tax}}">
					<label>@lang('sale.tax')</label>

					{!! Form::hidden("products[$row_count][item_tax]", @num_format($item_tax), ['class' => 'item_tax']); !!}
		
					{!! Form::select("products[$row_count][tax_id]", $tax_dropdown['tax_rates'], $tax_id, ['placeholder' => 'Select', 'class' => 'form-control tax_id'], $tax_dropdown['attributes']); !!}
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.close')</button>
		</div>
	</div>
</div>