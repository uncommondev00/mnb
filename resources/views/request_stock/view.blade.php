<div class="row">
	<div class="col-xs-12 col-sm-10 col-sm-offset-1">
		<div class="table-responsive">
			<table class="table table-condensed bg-gray">
				<tr>
					<th>@lang('sale.product')</th>
					
					<th>@lang('sale.qty')</th>
					<th>@lang('sale.unit_price')</th>
					<th>@lang('sale.subtotal')</th>
				</tr>
				@foreach( $stock_adjustment_details as $details )
					<tr>
						<td>
							{{ $details->product_name }} 
							( {{ $details->sub_sku }} )
						</td>
						<td>
							{{@format_quantity($details->quantity)}}
						</td>
						<td>
							{{@num_format($details->last_purchased_price)}}
						</td>
						<td>
							{{@num_format($details->last_purchased_price * $details->quantity)}}
						</td>
					</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>