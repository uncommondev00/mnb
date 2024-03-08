<table class='table table-condensed table-striped'>
	<tr>
	    <th>@lang('business.operations')</th>
	    <th>@lang('business.keyboard_shortcut')</th>
	</tr>

{{-- 	@if($pos_settings['disable_express_checkout'] == 0)
		<tr>
		    <td>@lang('sale.express_finalize'):</td>
		    <td>
			    @if(!empty($shortcuts["pos"]["express_checkout"]))
			    	{{ $shortcuts["pos"]["express_checkout"] }}
			    @endif
		    </td>
		</tr>
	@endif --}}

	@if($pos_settings['disable_pay_checkout'] == 0)
		<tr>
		    <td>@lang('Make Payment'):</td>
		    <td>
		    	@if(!empty($shortcuts["pos"]["pay_n_ckeckout"]))
			    	{{ $shortcuts["pos"]["pay_n_ckeckout"] }}
			    @endif
		    </td>
		</tr>
	@endif

	<tr>
	    <td>@lang('Suspend'):</td>
	    <td>
	    	shift+s
	    </td>
	</tr>

{{-- 	@if($pos_settings['disable_draft'] == 0)
		<tr>
		    <td>@lang('sale.draft'):</td>
		    <td>
		    	@if(!empty($shortcuts["pos"]["draft"]))
			    	{{ $shortcuts["pos"]["draft"] }}
			    @endif
		    </td>
		</tr>
	@endif --}}

	<tr>
	    <td>@lang('messages.cancel'):</td>
	    <td>
	    	@if(!empty($shortcuts["pos"]["cancel"]))
		    	{{ $shortcuts["pos"]["cancel"] }}
		    @endif
	    </td>
	</tr>

	@if($pos_settings['disable_discount'] == 0)
		<tr>
		    <td>@lang('sale.edit_discount'):</td>
		    <td>
		    	@if(!empty($shortcuts["pos"]["edit_discount"]))
			    	{{ $shortcuts["pos"]["edit_discount"] }}
			    @endif
		    </td>
		</tr>
	@endif

	{{-- @if($pos_settings['disable_order_tax'] == 0)
		<tr>
		    <td>@lang('sale.edit_order_tax'):</td>
		    <td>
		    	@if(!empty($shortcuts["pos"]["edit_order_tax"]))
			    	{{ $shortcuts["pos"]["edit_order_tax"] }}
			    @endif
		    </td>
		</tr>
	@endif --}}

	@if($pos_settings['disable_pay_checkout'] == 0)
		<tr>
		    <td>@lang('sale.add_payment_row'):</td>
		    <td>
		    	@if(!empty($shortcuts["pos"]["add_payment_row"]))
			    	{{ $shortcuts["pos"]["add_payment_row"] }}
			    @endif
		    </td>
		</tr>
	@endif

	@if($pos_settings['disable_pay_checkout'] == 0)
		<tr>
		    <td>@lang('sale.finalize_payment'):</td>
		    <td>
		    	@if(!empty($shortcuts["pos"]["finalize_payment"]))
			    	{{ $shortcuts["pos"]["finalize_payment"] }}
			    @endif
		    </td>
		</tr>
	@endif
	
	<tr>
	    <td>@lang('lang_v1.recent_product_quantity'):</td>
	    <td>
	    	@if(!empty($shortcuts["pos"]["recent_product_quantity"]))
		    	{{ $shortcuts["pos"]["recent_product_quantity"] }}
		    @endif
	    </td>
	</tr>

	<tr>
	    <td>@lang('Go to product price'):</td>
	    <td>
	    	f7
	    </td>
	</tr>

	<tr>
	    <td>@lang('Go to search product'):</td>
	    <td>
	    	@if(!empty($shortcuts["pos"]["add_new_product"]))
		    	{{ $shortcuts["pos"]["add_new_product"] }}
		    @endif
	    </td>
	</tr>

	<tr>
	    <td>@lang('Go to remove product'):</td>
	    <td>
	    	f8
	    </td>
	</tr>

	<tr>
	    <td>@lang('Go to select customer'):</td>
	    <td>
	    	ctrl+c
	    </td>
	</tr>

	<tr>
	    <td>@lang('Add new customer'):</td>
	    <td>
	    	alt+c
	    </td>
	</tr>

	<tr>
	    <td>@lang('Add new product'):</td>
	    <td>
	    	alt+p
	    </td>
	</tr>

	<tr>
	    <td>@lang('Remove last inserted product'):</td>
	    <td>
	    	Delete
	    </td>
	</tr>
	
</table>