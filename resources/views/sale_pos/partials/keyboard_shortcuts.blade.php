<script src="{{ asset('plugins/mousetrap/mousetrap.min.js?v=' . $asset_v) }}"></script>
<script type="text/javascript">
	$(document).ready( function() {


		//add customer
		Mousetrap.bind(['alt+c'], function(e) {					
				e.preventDefault();
				$('button#customer_add').trigger('click');
						$('.modal').on('shown.bs.modal', function() {
						  $(this).find('[autofocus]').focus();
						});
		    });

		//add customer
		Mousetrap.bind(['alt+p'], function(e) {					
				e.preventDefault();
				$('button.pos_add_quick_product').trigger('click');
						$('.modal').on('shown.bs.modal', function() {
						  $(this).find('[autofocus]').focus();
						});
		    });

		//suspend
		Mousetrap.bind(['shift+s'], function(e) {					
				e.preventDefault();
				$('#suspend_sell').trigger('click');
		});


		//shortcut for express checkout disabled
		@if(!empty($shortcuts["pos"]["express_checkout"]) && ($pos_settings['disable_express_checkout'] == 1))
			Mousetrap.bind('{{$shortcuts["pos"]["express_checkout"]}}', function(e) {
				e.preventDefault();
				$('button.pos-express-finalize[data-pay_method="cash"]').trigger('click');
			});
		@endif

		//shortcut for cancel checkout
		@if(!empty($shortcuts["pos"]["cancel"]))
			Mousetrap.bind('{{$shortcuts["pos"]["cancel"]}}', function(e) {
				e.preventDefault();
				$('#pos-cancel').trigger('click');
			});
		@endif

		//shortcut for draft checkout disabled
		@if(!empty($shortcuts["pos"]["draft"]) && ($pos_settings['disable_draft'] == 1))
			Mousetrap.bind('{{$shortcuts["pos"]["draft"]}}', function(e) {
				e.preventDefault();
				$('#pos-draft').trigger('click');
			});
		@endif

		//shortcut for draft pay & checkout
		@if(!empty($shortcuts["pos"]["pay_n_ckeckout"]) && ($pos_settings['disable_pay_checkout'] == 0))
			Mousetrap.bind('{{$shortcuts["pos"]["pay_n_ckeckout"]}}', function(e) {
				e.preventDefault();
				$('#pos-finalize').trigger('click');
			});
		@endif

		//shortcut for edit discount
		@if(!empty($shortcuts["pos"]["edit_discount"]) && ($pos_settings['disable_discount'] == 0))
			Mousetrap.bind('{{$shortcuts["pos"]["edit_discount"]}}', function(e) {
				e.preventDefault();
				$('#pos-new-edit-discount').trigger('click');
			});
		@endif

		//shortcut for edit tax disabled
		@if(!empty($shortcuts["pos"]["edit_order_tax"]) && ($pos_settings['disable_order_tax'] == 1))
			Mousetrap.bind('{{$shortcuts["pos"]["edit_order_tax"]}}', function(e) {
				e.preventDefault();
				$('#pos-edit-tax').trigger('click');
			});
		@endif

		//shortcut for add payment row
		@if(!empty($shortcuts["pos"]["add_payment_row"]) && ($pos_settings['disable_pay_checkout'] == 0))
			var payment_modal = document.querySelector('#modal_payment');
			Mousetrap.bind('{{$shortcuts["pos"]["add_payment_row"]}}', function(e, combo) {
				if($('#modal_payment').is(':visible')){
					e.preventDefault();
					$('#add-payment-row').trigger('click');
				}
			});
		@endif

		//shortcut for add finalize payment
		@if(!empty($shortcuts["pos"]["finalize_payment"]) && ($pos_settings['disable_pay_checkout'] == 0))
			var payment_modal = document.querySelector('#modal_payment');
			Mousetrap(payment_modal).bind('{{$shortcuts["pos"]["finalize_payment"]}}', function(e, combo) {
				if($('#modal_payment').is(':visible')){
					e.preventDefault();
					$('#pos-save').trigger('click');
				}
			});
		@endif

		//Shortcuts to go recent product quantity
		@if(!empty($shortcuts["pos"]["recent_product_quantity"]))
			shortcut_length_prev = 0;
			shortcut_position_now = null;

			Mousetrap.bind('{{$shortcuts["pos"]["recent_product_quantity"]}}', function(e, combo) {
				var length_now = $('table#pos_table tr').length;

				if(length_now != shortcut_length_prev){
					shortcut_length_prev = length_now;
					shortcut_position_now = length_now;
				} else {
					shortcut_position_now = shortcut_position_now - 1;
				}

				var last_qty_field = $('table#pos_table tr').eq(shortcut_position_now - 1).contents().find('input.pos_quantity');
				if(last_qty_field.length >=1){
					last_qty_field.focus().select();
				} else {
					shortcut_position_now = length_now + 1;
					Mousetrap.trigger('{{$shortcuts["pos"]["recent_product_quantity"]}}');
				}
			});

			//On focus of quantity field go back to search when stop typing
			var timeout = null;
			$('table#pos_table').on('focus', 'input.pos_quantity', function () {
			    var that = this;

			    $(this).on('keyup', function(e){

			    	if (timeout !== null) {
			        	clearTimeout(timeout);
			    	}

			    	var code = e.keyCode || e.which;
			    	if (code != '9') {
    					timeout = setTimeout(function () {
			        		$('input#search_product').focus().select();
			    		}, 5000);
    				}
			    });
			});
		@endif

		//shortcut to go to add new products
		@if(!empty($shortcuts["pos"]["add_new_product"]))
			Mousetrap.bind('{{$shortcuts["pos"]["add_new_product"]}}', function(e) {
				$('input#search_product').focus().select();
			});
		@endif

		//go to pos_unit_price_inc_tax 
		Mousetrap.bind('f7', function(e, combo) {
				var length_now = $('table#pos_table tr').length;

				if(length_now != shortcut_length_prev){
					shortcut_length_prev = length_now;
					shortcut_position_now = length_now;
				} else {
					shortcut_position_now = shortcut_position_now - 1;
				}

				var last_qty_field = $('table#pos_table tr').eq(shortcut_position_now - 1).contents().find('input.pos_unit_price_inc_tax');
				if(last_qty_field.length >=1){
					last_qty_field.focus().select();
				} else {
					shortcut_position_now = length_now + 1;
					Mousetrap.trigger('f7');
				}
			});

		//go to pos_remove_row
		Mousetrap.bind('f8', function(e, combo) {

				var length_now = $('table#pos_table tr').length;

				if(length_now != shortcut_length_prev){
					shortcut_length_prev = length_now;
					shortcut_position_now = length_now;
				} else {
					shortcut_position_now = shortcut_position_now - 1;
				}

				var last_qty_field = $('table#pos_table tr').eq(shortcut_position_now - 1).contents().find('button.pos_remove_row');
				if(last_qty_field.length >=1){
					last_qty_field.focus().select();
				} else {
					shortcut_position_now = length_now + 1;
					Mousetrap.trigger('f8');
				}
			});

		//customer shortcut
		Mousetrap.bind('ctrl+c', function(e) {
				$('#customer_id').select2("open");
			});

		//price group shortcut
		Mousetrap.bind('f9', function(e) {
				$('#price_group').trigger("focus");

			});
	});
</script>