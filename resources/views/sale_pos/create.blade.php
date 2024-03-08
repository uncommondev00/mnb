@extends('layouts.app')

@section('title', 'POS')

@section('css')
<style>
       .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
            /* add padding to account for vertical scrollbar */
            padding-right: 20px;
        } 
</style>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<!-- <section class="content-header">
    <h1>Add Purchase</h1> -->
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
<!-- </section> -->

<!-- Main content -->
<section class="content no-print">
	<div class="row" >
		<div class="@if(!empty($pos_settings['hide_product_suggestion']) && !empty($pos_settings['hide_recent_trans'])) col-md-10 col-md-offset-1 @else col-md-7 @endif col-sm-12">
			@component('components.widget', ['class' => 'box-success'])
				@slot('header')
					<div class="col-sm-12">
						<div class="col-sm-6">
							<h3 class="box-title">POS Terminal <i class="fa fa-keyboard-o hover-q text-muted" aria-hidden="true" data-container="body" data-toggle="popover" data-placement="bottom" data-content="@include('sale_pos.partials.keyboard_shortcuts_details')" data-html="true" data-trigger="hover" data-original-title="" title=""></i></h3>
						</div>
						<div class="col-sm-6 text-right">
							@include('layouts.partials.header-pos')
						</div>
					
					</div>
					<input type="hidden" id="item_addition_method" value="{{$business_details->item_addition_method}}">
					@if(is_null($default_location))
						<div class="col-sm-6">
							<div class="form-group" style="margin-bottom: 0px;">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-map-marker"></i>
									</span>
								{!! Form::select('select_location_id', $business_locations, null, ['class' => 'form-control input-sm mousetrap', 
								'placeholder' => __('lang_v1.select_location'),
								'id' => 'select_location_id', 
								'required', 'autofocus'], $bl_attributes); !!}
								<span class="input-group-addon">
										@show_tooltip(__('tooltip.sale_location'))
									</span> 
								</div>
							</div>
						</div>
					@endif
				@endslot
				{!! Form::open(['url' => action('SellPosController@store'), 'method' => 'post', 'id' => 'add_pos_sell_form' ]) !!}

				{!! Form::hidden('location_id', $default_location, ['id' => 'location_id', 'data-receipt_printer_type' => isset($bl_attributes[$default_location]['data-receipt_printer_type']) ? $bl_attributes[$default_location]['data-receipt_printer_type'] : 'browser']); !!}
				<input type="hidden" name="prev_points" id="prev_points" value="0" placeholder="previous points">
				<input type="hidden" name="points_value" id="points_value" value="0" placeholder="total points">
				<input type="hidden" name="points_amount" id="points_amount" value="{{$points->points_amount}}" placeholder="min amount to gain points">
				<input type="hidden" name="points" id="points" value="{{$points->points}}" placeholder="points to give">
				<input type="hidden" name="points_tobe_added" id="points_tobe_added" value="0" placeholder="points to be added">
				<input type="hidden" name="points_status" id="points_status" value="0" placeholder="points status">
				<input type="hidden" id="points_is_suspend" value="1" placeholder="points is suspend">
				<!-- /.box-header -->
				<div class="box-body">
					<div class="row">
						@if(config('constants.enable_sell_in_diff_currency') == true)
							<div class="col-md-4 col-sm-6">
								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-exchange"></i>
										</span>
										{!! Form::text('exchange_rate', config('constants.currency_exchange_rate'), ['class' => 'form-control input-sm input_number', 'placeholder' => __('lang_v1.currency_exchange_rate'), 'id' => 'exchange_rate']); !!}
									</div>
								</div>
							</div>
						@endif
						@if(!empty($price_groups))
							@if(count($price_groups) > 1)
								<div class="col-md-4 col-sm-6">
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-money"></i>
											</span>
											@php
												reset($price_groups);
											@endphp
											{!! Form::hidden('hidden_price_group', key($price_groups), ['id' => 'hidden_price_group']) !!}
											{!! Form::select('price_group', $price_groups, null, ['class' => 'form-control select2', 'id' => 'price_group', 'style' => 'width: 100%;']); !!}
											<span class="input-group-addon">
												@show_tooltip(__('lang_v1.price_group_help_text'))
											</span> 
										</div>
									</div>
								</div>
							@else
								@php
									reset($price_groups);
								@endphp
								{!! Form::hidden('price_group', key($price_groups), ['id' => 'price_group']) !!}
							@endif
						@endif
						
						@if(in_array('subscription', $enabled_modules))
							<div class="col-md-4 pull-right col-sm-6">
								<div class="checkbox">
									<label>
						              {!! Form::checkbox('is_recurring', 1, false, ['class' => 'input-icheck', 'id' => 'is_recurring']); !!} @lang('lang_v1.subscribe')?
						            </label><button type="button" data-toggle="modal" data-target="#recurringInvoiceModal" class="btn btn-link"><i class="fa fa-external-link"></i></button>@show_tooltip(__('lang_v1.recurring_invoice_help'))
								</div>
							</div>
						@endif
					</div>
					<div class="row">
						<div class="@if(!empty($commission_agent)) col-sm-4 @else col-sm-6 @endif">
							<div class="form-group" style="width: 100% !important" >
								<div class="input-group" id="form_default">
									<span class="input-group-addon">
										<i class="fa fa-user"></i>
									</span>

									<!--for ip address-->
				
									<?php 
						                $server_permission_1 = $_SERVER['REMOTE_ADDR'];

						                $permit_Add="";

						                $arp=`arp -a $server_permission_1`;
						                $lines=explode("\n", $arp);

						                foreach($lines as $line)
						                {
						                   $cols=preg_split('/\s+/', trim($line));
						                   if ($cols[0]==$server_permission_1)
						                   {
						                   $permit_Add = $cols[0]; 
						                   }

						                }
					            	?>

									<input type="hidden" name="ip_address" 
									value="<?php echo $permit_Add; ?>">

									<!--for mac address-->
									
					            	<?php 
						                $server_permission_2 = $_SERVER['REMOTE_ADDR'];

						                $permit_Add_2 ="";

						                $arp=`arp -a $server_permission_2`;
						                $lines=explode("\n", $arp);

						                foreach($lines as $line)
						                {
						                   $cols=preg_split('/\s+/', trim($line));
						                   if ($cols[0]==$server_permission_2)
						                   {
						                    $permit_Add_2 = $cols[1];
						                   }
						                }
					            	?>

					            	<input type="hidden" name="mac_address" 
									value="<?php

											if(empty($permit_Add_2)){
												echo " ";
											}else{
												echo $permit_Add_2;
											}
											
								 			?>">
	
									<!--end-->

									<input type="hidden" id="default_customer_id" 
									value="{{ $walk_in_customer['id']}}" >
									<input type="hidden" id="default_customer_name" 
									value="{{ $walk_in_customer['name']}}" >
									{!! Form::select('contact_id', 
										[], null, ['class' => 'form-control mousetrap', 'id' => 'customer_id', 'placeholder' => 'Enter Customer name / phone', 'required', 'style' => 'width: 100%;']); !!}
									<span class="input-group-btn">
										<button type="button" class="btn btn-default bg-white btn-flat add_new_customer mousetrap" id="customer_add" data-name=""  @if(!auth()->user()->can('customer.create')) disabled @endif><i class="fa fa-plus-circle text-primary fa-lg"></i></button>
									</span>
								</div>
								<!--senior-->
							<div class="form-group" id="form_senior">
								<div class="input-group" >
									<span class="input-group-addon">
										<i class="fa fa-user"></i>
									</span>
									<input class="form-control mousetrap" id="cust" style="width:100%;" type="text" readonly>
									<span class="input-group-btn">
										<button type="button" class="btn btn-default bg-white btn-flat add_new_customer" data-name=""><i class="fa fa-plus-circle text-primary fa-lg"></i></button>
									</span>
								</div>
							</div>
							</div>
						</div>
						<input type="hidden" name="pay_term_number" id="pay_term_number" value="{{$walk_in_customer['pay_term_number']}}">
						<input type="hidden" name="pay_term_type" id="pay_term_type" value="{{$walk_in_customer['pay_term_type']}}">
						
						@if(!empty($commission_agent))
							<div class="col-sm-4">
								<div class="form-group">
								{!! Form::select('commission_agent', 
											$commission_agent, null, ['class' => 'form-control select2', 'placeholder' => __('lang_v1.commission_agent')]); !!}
								</div>
							</div>
						@endif

						<div class="@if(!empty($commission_agent)) col-sm-4 @else col-sm-6 @endif">
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-barcode"></i>
									</span>
									{!! Form::text('search_product', null, ['class' => 'form-control mousetrap', 'id' => 'search_product', 'placeholder' => __('lang_v1.search_product_placeholder'),
									'disabled' => is_null($default_location)? true : false,
									'autofocus' => is_null($default_location)? false : true,
									]); !!}
									<span class="input-group-btn">
										<button type="button" class="btn btn-default bg-white btn-flat pos_add_quick_product" data-href="{{action('ProductController@quickAdd')}}" data-container=".quick_add_product_modal" @if(!auth()->user()->can('product.create')) disabled @endif><i class="fa fa-plus-circle text-primary fa-lg"></i></button>
									</span>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>

						<!-- Call restaurant module if defined -->
				        @if(in_array('tables' ,$enabled_modules) || in_array('service_staff' ,$enabled_modules))
				        	<span id="restaurant_module_span">
				          		<div class="col-md-3"></div>
				        	</span>
				        @endif
			        </div>

					<div class="row">
					<div class="col-sm-12 pos_product_div">
						<input type="hidden" name="sell_price_tax" id="sell_price_tax" value="{{$business_details->sell_price_tax}}">

						<!-- Keeps count of product rows -->
						<input type="hidden" id="product_row_count" 
							value="0">
						@php
							$hide_tax = '';
							if( session()->get('business.enable_inline_tax') == 0){
								$hide_tax = 'hide';
							}
						@endphp
						<input class="hidden" id="date_trans" name="date_trans" type="text">
						<table class="table table-condensed table-bordered table-striped table-responsive" id="pos_table">
							<thead>
								<tr>
									<th class="tex-center @if(!empty($pos_settings['inline_service_staff'])) col-md-3 @else col-md-4 @endif">	
										@lang('sale.product') @show_tooltip(__('lang_v1.tooltip_sell_product_column'))
									</th>
									<th class="text-center col-md-3">
										@lang('sale.qty')
									</th>
									@if(!empty($pos_settings['inline_service_staff']))
										<th class="text-center col-md-2">
											@lang('restaurant.service_staff')
										</th>
									@endif
									<th class="text-center col-md-2 {{$hide_tax}}">
										@lang('sale.price_inc_tax')
									</th>
									<th class="text-center col-md-2" style="width: 100px;">
										@lang('Discount (%)')
									</th>
									<th class="text-center col-md-2">
										@lang('sale.subtotal')
									</th>
									<th class="text-center"><i class="fa fa-close" aria-hidden="true"></i></th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
						</div>
					</div>

					@include('sale_pos.partials.pos_details')

					@include('sale_pos.partials.payment_modal')

					@if(empty($pos_settings['disable_suspend']))
						@include('sale_pos.partials.suspend_note_modal')
					@endif

					@if(empty($pos_settings['disable_recurring_invoice']))
						@include('sale_pos.partials.recurring_invoice_modal')
					@endif
				</div>
				<!-- /.box-body -->
				{!! Form::close() !!}
			@endcomponent
		</div>

		<div class="col-md-5 col-sm-12">
			@include('sale_pos.partials.right_div')
			@include('sale_pos.emergency_drawer_modal')
		</div>
	</div>
</section>

<!-- This will be printed -->
<section class="invoice print_section" id="receipt_section">
</section>
<div class="modal fade contact_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
	@include('contact.create', ['quick_add' => true])
</div>
<!-- /.content -->
<div class="modal fade register_details_modal" tabindex="-1" role="dialog" 
	aria-labelledby="gridSystemModalLabel">
</div>
<div class="modal fade close_register_modal" tabindex="-1" role="dialog" 
	aria-labelledby="gridSystemModalLabel">
</div>
<!--CASH CHANGE MODAL-->
<div class="modal fade cash_change_modal no-print" tabindex="-1" role="dialog" 
	aria-labelledby="gridSystemModalLabel">
	<div class="modal-dialog" role="document">
  <div class="modal-content">


    <div class="modal-header">
      <h4 class="modal-title">
      	Invoice : <span id="invce_no"></span>
      </h4>
    </div>

    <div class="modal-body">
      <div class="row">
      	<div class="col-sm-12">
          <div class="form-group">
            <h1>Quantity: <span id="qty_total"></span></h1>
          </div>
        </div>
      	<div class="col-sm-12">
          <div class="form-group">
            <h1>Subtotal: <span id="sb_total"></span></h1>
          </div>
        </div>
      	<div class="col-sm-12">
          <div class="form-group">
            <h1>Cash: <span id="cash_change"></span></h1>
          </div>
        </div>
         <div class="col-sm-12">
          <div class="form-group">
            <h1>Change: <span id="change_cash" class="text-danger"></span></h1>
          </div>
        </div>
      	
      	
      </div>
        
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>



  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>

<!-- quick product modal -->
<div class="modal fade quick_add_product_modal" tabindex="-1" role="dialog" aria-labelledby="modalTitle"></div>

<iframe id="textfile2" src="{{action('DenominationController@openDrawer') }}" style="display: none;"></iframe>

@stop

@section('javascript')

<script type="text/javascript">
	
$(document).ready(function(){
	document.onkeydown = function(e)
	{
		if(e.ctrlKey)
		{
			e.preventDefault();
			return false;
		}
	}
	
	document.getElementById("input_open_PIN").value = "";
});

	
	function input_valid(){
		var s_id = document.getElementById('s_id').value;
		var s_name = document.getElementById('s_name').value;
		var s_addr = document.getElementById('s_addr').value;

		if(s_id == "" || s_name == "" || s_addr == "" ){
			$("#btn_cancel").show();
			$("#btn_ok").hide();
			document.getElementById("error_msg").innerHTML = "Please filled out the fields!";
		}else{
			$("#add_discount_section").hide();
	    	$("#btn_ok").hide();
         	$("#add_discount_section_1").show();
       		$('#input_discount_PIN').focus();
		}

	}
</script>

<!--open drawer-->
<script type="text/javascript">
    $('#open_drawer').click(function() {
        $('#open_drawer_modal').modal('show');
    });

    $(document).on('shown.bs.modal', function () {
	    	$('#input_open_PIN').focus();

	    	$("#security_section1").show();
	    	$("#security_section2").hide();
	    	document.getElementById("input_open_PIN").value = "";
	    });

	          var opins = ["{{config('app.security')}}"];

      function opincode(opin) {
        return opin == document.getElementById("input_open_PIN").value;
      }


	    function myPin2() {
        if (document.getElementById("open_drawer_PIN").innerHTML = opins.find(opincode) == undefined){
              document.getElementById("open_drawer_PIN").innerHTML = "Incorrect Pincode!";
              document.getElementById("input_open_PIN").value = "";

         }else{
           document.getElementById("open_drawer_PIN").innerHTML = "";
             $("#security_section2").show("#security_section2"), $("#security_section1").hide("#security_section1");
	        
          }
      }

</script>

	<!--open drawer-->
	<script type="text/javascript">
		function opened() {
		    var iframe = document.getElementById('textfile2');
		    iframe.contentWindow.print();
		    var routeUrl2 = "{{action('SellPosController@create')}}"
          	document.location.href=routeUrl2;

		}
	</script>


	<!--For discount pincode-->
	<script type="text/javascript">
	
			
			function myScreen(){

			var dual_s = "{{config('app.dual')}}";

			if(dual_s == "active"){
					var width = 650;
					var left = 1360;

						   // left += window.screenX;
					var total_payable = document.getElementById("final_total_input").value;
				
					var myWindow = window.open("", "totalPayable", 'resizable=1,scrollbars=1,fullscreen=0,height=200,width=' + width + '  , left=' + left + ', toolbar=0, menubar=0,status=1');
		  			myWindow.document.body.innerHTML = '';
		  			myWindow.document.write(window.screen.availWidth);

	  				}else{

	  				}
			}
	
			$(document).ready(function() {
					

				    $('select#customer_id').change(function() {
				        var e = document.getElementById("customer_id");
						var strUser = e.options[e.selectedIndex].text;

						document.getElementById('cust').value = strUser;
						//Senior Citizen
						if(strUser == "Senior Citizen (CO0002)"){
						//var sss = strUser;
						//alert(strUser);
							$('div#form_default').show();
							$('div#form_senior').hide();
							//$('div#form_senior').show();
							//$('div#form_default').hide();
							//$('div#posAddDiscountModal').modal('show');
						//document.write(sss)
						}else{
							$('div#form_default').show();
							$('div#form_senior').hide();
							//$('div#form_senior').hide();
							//$('div#form_default').show();
							//$('div#posAddDiscountModal').modal('hide');
						}

						
				    });
				
			});

			function autoNote(){
					//var num =  Math.floor(Math.random() * 123456789);
					//document.getElementById("cookie_note").value = num;
					var note = document.getElementById("total_discount_val").innerHTML;

					if(note == 0){
						document.getElementById("cookie_note").value = "no discount";
					}else{
						document.getElementById("cookie_note").value = note;
					}
					
			}	
		
	    $(document).on('shown.bs.modal', function () {

	    	var c = document.getElementById("customer_id");
			var strCus = c.options[c.selectedIndex].text;

			if(strCus != "Senior Citizen (CO0002)"){

			$("#btn_add_discount").hide();
			$("#add_discount_section").hide();
			$("#btn_cancel").hide();
	    	$("#btn_ok").hide();
         	$("#add_discount_section_1").show();
         	$("#add_discount_section_2").hide();
       		$('#input_discount_PIN').focus();

			}else{
				
			$("#add_discount_section").show();
	    	$('#s_id').focus();
	    	$("#btn_ok").show();
	    	$("#add_discount_section_1").hide();
	    	$("#add_discount_section_2").hide();
	    	$("#btn_add_discount").hide()
	    	$("#btn_cancel").hide();

	    	document.getElementById("error_msg").innerHTML = "";


	    	 $("#btn_add_discount").click(function(){
	             $("#add_discount_section").show();
	             document.getElementById("input_discount_PIN").value = "";
             	$("#btn_ok").show();
          	});
	    	}
	    });

	var pins = ["{{config('app.security')}}"];

      function pincode(pin) {
        return pin == document.getElementById("input_discount_PIN").value;
      }


	    function myPin() {
        if (document.getElementById("Check_discount_PIN").innerHTML = pins.find(pincode) == undefined){
              document.getElementById("Check_discount_PIN").innerHTML = "Incorrect Pincode!";
              //alert($('#input_discount_PIN').val())
              document.getElementById("input_discount_PIN").value = "";

         }else{
         	//alert($('#input_discount_PIN').val())
              document.getElementById("input_discount_PIN").value = "";
           document.getElementById("Check_discount_PIN").innerHTML = "";
             $("#add_discount_section_2").show("#add_discount_section_2"),  $("#add_discount_section_1").hide("#add_discount_section_1"), $("#btn_add_discount").show();
	        
          }
      }
	</script>
	<!--For the value of discount-->
	<script type="text/javascript">
			function setCookie2(cname2, cvalue2, exdays2) {
			  var d2 = new Date();
			  d2.setTime(d2.getTime() + (exdays2 * 24 * 60 * 60 * 1000));
			  var expires2 = "expires2="+d2.toUTCString();
			  document.cookie = cname2 + "=" + cvalue2 + ";" + expires2 + ";path=/";
			}

			function getCookie2(cname2) {
			  var name2 = cname2 + "=";
			  var ca2 = document.cookie.split(';');
			  for(var i = 0; i < ca2.length; i++) {
			    var c2 = ca2[i];
			    while (c2.charAt(0) == ' ') {
			      c2 = c2.substring(1);
			    }
			    if (c2.indexOf(name2) == 0) {
			      return c2.substring(name2.length, c2.length);
			    }
			  }
			  return "";
			}

			function checkCookie2() {
				disc25 = document.getElementById("cookie_note").value;
			  var disc2 = getCookie2(disc25);
			  if (disc2 != "") {
			    //alert("Your Discount is " + disc);
			    
			    var vd = getCookie("discount");
			    document.getElementById("total_discount_val").innerHTML = vd;
			    if (disc2 != "" && disc2 != null) {
			      setCookie2(disc2, vd, 999 );
			      setCookie2("discount", 0, 999);
			      document.getElementById("total_discount_val").innerHTML = 0;
			    }
			   
			  } else {
			    disc2 = document.getElementById("cookie_note").value;
			    var vd = getCookie("discount");
			    document.getElementById("total_discount_val").innerHTML = vd;
			    if (disc2 != "" && disc2 != null) {
			      setCookie2( disc2, vd, 999 );
			      setCookie2("discount", 0, 999);
			      document.getElementById("total_discount_val").innerHTML = 0;
			    }
			  }
			}

			function delete_cookie() {
    			setCookie("discount", 0, 999);
    			document.getElementById("total_discount_val").innerHTML = 0;
				};
			
			
	</script>

		<!-- Destroy cooki for suspend and finalize payment-->
	<script type="text/javascript">


			function setCookie(cname, cvalue, exdays) {
			  var d = new Date();
			  d.setTime(d.getTime() + (exdays * 5 * 1000));
			  var expires = "expires="+d.toUTCString();
			  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
			}

			function getCookie(cname) {
			  var name = cname + "=";
			  var ca = document.cookie.split(';');
			  for(var i = 0; i < ca.length; i++) {
			    var c = ca[i];
			    while (c.charAt(0) == ' ') {
			      c = c.substring(1);
			    }
			    if (c.indexOf(name) == 0) {
			      return c.substring(name.length, c.length);
			    }
			  }
			  return "";
			}

			function checkCookie() {	
			  var disc = getCookie("discount");
			  if (disc != "") {
			    //alert("Your Discount is " + disc);
			    disc = document.getElementById("discount_value_modal").value;
			    document.getElementById("total_discount_val").innerHTML = disc;
			    if (disc != "" && disc != null) {
			      setCookie("discount", disc, 999);
			    }
			   
			  } else {
			  	//alert(disc);
			    disc = document.getElementById("discount_value_modal").value;
			    document.getElementById("total_discount_val").innerHTML = disc;
			    if (disc != "" && disc != null) {
			      setCookie("discount", disc, 999 );
			    }
			  }

			}

			$('button#btn_add_discount').on('click', function(){
				//alert($('#discount_value_modal').val())
				var disc_val = $('#discount_value_modal').val();

				if(disc_val == "")
				{
					//alert(disc_val)
					document.getElementById("total_discount_val").innerHTML = 0;
				}

			});



			function delete_cookie() {
    			setCookie("discount", 0, 999);
    			document.getElementById("total_discount_val").innerHTML = 0;
				};

			
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			
			//payment_types_dropdown
			//payment_row_index
            $('div#payment_rows_div').on('change', '.payment_types_dropdown', function(){
            	var select_val = $(this).val();
            	var div =  $(this).parents('#tr_row');

            	var indx = div.find('.payment_row_index').val();

            	var amount = div.find('.payment-amount').val();

            	var n_amnt = amount.replace(",", "");

            	if(select_val == 'points')
            	{
            		var rp = $('input#points_value').val();
            		$('input.input_total_points').val(rp);

            		var points = div.find('.input_total_points').val();

		            //$('input.input_total_points').val(rp);
		            var diff_p = points - n_amnt;
		            if(diff_p < 0)
	            	{
	            		toastr.error('Insufficient points.');
	            		$('#pos-save').attr('disabled', 'true');
	            		//alert(diff_p);
	            	}
	            	else
	            	{
	            		$('input.input_total_points').val(diff_p);
	            		$('input#points_value').val(diff_p);
	            		$('#pos-save').removeAttr('disabled');
	            	}

            		//alert(points);
            	}
            	else
            	{
            		$('#pos-save').removeAttr('disabled');
            	}

            		//cannot repeat payment method
            	    var payment_type_value = [];

				    $('div#payment_rows_div #tr_row').each(function() {
				        var p_t =  $(this).find('.payment_types_dropdown').val();
				        payment_type_value.push(p_t)

				        //alert(p_t);
				        
				     });

				    //alert(payment_type_value);

				        
				        $('div#payment_rows_div #tr_row').find("option").prop("disabled", false); 
				        $('div#payment_rows_div #tr_row').find("option").css({"color" : "black"});      
				          for (var index in payment_type_value) {

				            //$('option[value="'+payment_type_value[index]+'"]').prop("disabled", true); 
				            $('div#payment_rows_div #tr_row').find('option[value="' + payment_type_value[index] + '"]:not(:selected)')
				            .prop("disabled", true);

				            $('div#payment_rows_div #tr_row').find('option[value="' + payment_type_value[index] + '"]:not(:selected)').css({"color" : "#C8C8C8"});

				          }

            	
            });
		});
	</script>


	<script src="{{ asset('js/pos.js?v=' . $asset_v) }}"></script>
	<script src="{{ asset('js/printer.js?v=' . $asset_v) }}"></script>
	<script src="{{ asset('js/product.js?v=' . $asset_v) }}"></script>
	<script src="{{ asset('js/opening_stock.js?v=' . $asset_v) }}"></script>
	@include('sale_pos.partials.keyboard_shortcuts')

	<!-- Call restaurant module if defined -->
    @if(in_array('tables' ,$enabled_modules) || in_array('modifiers' ,$enabled_modules) || in_array('service_staff' ,$enabled_modules))
    	<script src="{{ asset('js/restaurant.js?v=' . $asset_v) }}"></script>
    @endif
@endsection
