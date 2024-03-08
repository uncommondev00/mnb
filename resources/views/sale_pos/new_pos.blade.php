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
							
						</div>
						<div class="col-sm-6 text-right">
							<div class="col-md-12 no-print pos-header">
							  <div class="row">
							  	<a href="{{action('Auth\LoginController@logout')}}" class="btn btn-default btn-flat">@lang('lang_v1.sign_out')</a>
							  </div>
							</div>
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
									{{-- <span class="input-group-btn">
										<button type="button" class="btn btn-default bg-white btn-flat add_new_customer mousetrap" id="customer_add" data-name=""  @if(!auth()->user()->can('customer.create')) disabled @endif><i class="fa fa-plus-circle text-primary fa-lg"></i></button>
									</span> --}}
								</div>
								<!--senior-->
							<div hidden="" class="form-group" id="form_senior">
								<div class="input-group" >
									<span class="input-group-addon">
										<i class="fa fa-user"></i>
									</span>
									<input class="form-control mousetrap" id="cust" style="width:100%;" type="text" readonly>
									{{-- <span class="input-group-btn">
										<button type="button" class="btn btn-default bg-white btn-flat add_new_customer" data-name=""><i class="fa fa-plus-circle text-primary fa-lg"></i></button>
									</span> --}}
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
									{{-- <span class="input-group-btn">
										<button type="button" class="btn btn-default bg-white btn-flat pos_add_quick_product" data-href="{{action('ProductController@quickAdd')}}" data-container=".quick_add_product_modal" @if(!auth()->user()->can('product.create')) disabled @endif><i class="fa fa-plus-circle text-primary fa-lg"></i></button>
									</span> --}}
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

					@include('sale_pos.partials.new_pos_details')

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
