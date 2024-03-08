<style>
.pos2-container{
    padding:2mm;
  margin: 0 auto;
  width: 7.5in;
  /*height: 5.5in;*/
  background: #FFF;
  font-family: sans-serif !important; 
  color: black !important;
  font-weight: bold !important;
}


</style>

<div class="pos2-container">
	


<table style="width:100%;">

	<tbody>
		<tr>
			<td>

<!-- business information here -->
<div class="row invoice-info">

	<div class="col-md-6 invoice-col width-50 " class="">
		
		<!-- Logo -->
		@if(!empty($receipt_details->logo))
			<img src="{{$receipt_details->logo}}" class="img">
			<br/>
		@endif

		<!-- Shop & Location Name  -->
		@if(!empty($receipt_details->display_name))
			<b><p>
				{{$receipt_details->display_name}}
				@if(!empty($receipt_details->address))
					<br/>{!! $receipt_details->address !!}
				@endif

				@if(!empty($receipt_details->contact))
					<br/>{{ $receipt_details->contact }}
				@endif

				{{-- @if(!empty($receipt_details->website))
					<br/>{{ $receipt_details->website }}
				@endif --}}

				@if(!empty($receipt_details->tax_info1))
					<br/>{{ $receipt_details->tax_label1 }} {{ $receipt_details->tax_info1 }}
				@endif

				@if(!empty($receipt_details->tax_info2))
					<br/>{{ $receipt_details->tax_label2 }} {{ $receipt_details->tax_info2 }}
				@endif

				@if(!empty($receipt_details->location_custom_fields))
					<br/>{{ $receipt_details->location_custom_fields }}
				@endif
			</p></b>
		@endif

		<!-- Table information-->
        @if(!empty($receipt_details->table_label) || !empty($receipt_details->table))
        	<p>
				@if(!empty($receipt_details->table_label))
					{!! $receipt_details->table_label !!}
				@endif
				{{$receipt_details->table}}
			</p>
        @endif

		<!-- Waiter info -->
		@if(!empty($receipt_details->service_staff_label) || !empty($receipt_details->service_staff))
        	<p>
				@if(!empty($receipt_details->service_staff_label))
					{!! $receipt_details->service_staff_label !!}
				@endif
				{{$receipt_details->service_staff}}
			</p>
        @endif
	</div>

	<div class="col-md-6 invoice-col width-50">

		<b><p class="text-right">
			@if(!empty($receipt_details->invoice_no_prefix))
				<span class="pull-left">{!! $receipt_details->invoice_no_prefix !!}</span>
			@endif

			{{$receipt_details->invoice_no}}
		</p></b>

		<!-- Total Due-->
		@if(!empty($receipt_details->total_due))
			<b><p class="text-right">
				<span class="pull-left">
					{!! $receipt_details->total_due_label !!}
				</span>

				{{$receipt_details->total_due}}
			</p></b>
		@endif

		
		<!-- Total Paid-->
		@if(!empty($receipt_details->total_paid))
			<b><p class="text-right">
				<span class="pull-left"><b>{!! $receipt_details->total_paid_label !!}</b></span>
				<b>{{$receipt_details->total_paid}}</b>
			</p></b>
		@endif
		<!-- Date-->
		@if(!empty($receipt_details->date_label))
			<b><p class="text-right">
				<span class="pull-left">
					{{$receipt_details->date_label}}
				</span>

				{{$receipt_details->invoice_date}}
			</p></b>
		@endif
	</div>
</div>

<div class="row invoice-info ">

	<div class="col-md-6 invoice-col width-50 word-wrap">
		@if(!empty($receipt_details->customer_label))
			<b>{{ $receipt_details->customer_label }}:</b>
		@endif

		<!-- customer info -->
		@if(!empty($receipt_details->customer_name))
			<b>{{ $receipt_details->customer_name }}</b>
		@endif

		@if(!empty($receipt_details->sales_person_label))
			<br/>
			<strong>{{ $receipt_details->sales_person_label }}</strong> <b>{{ $receipt_details->sales_person }}</b>
		@endif
	</div>
	
</div>



<div class="row ">
	<center>
	<div class="col-xs-12">
		<hr style="border: 1px dashed" />
		<table class="table-bordered col-xs-12" >
			<thead>
				<tr style=" font-size: 12px !important">

					<th class= "text-center" style=" width: 5% !important">#</th>
					
					@php
						$p_width = 50;
					@endphp
					@if($receipt_details->show_cat_code != 1)
						@php
							$p_width = 45;
						@endphp
					@endif
					<th class= "text-center" style=" width: {{40}}% !important">
						Item
					</th>
					<th class= "text-center" style=" width: 15% !important;">
						Qty
					</th>
					<th class= "text-center" style=" width: 20% !important;">
						{{$receipt_details->table_unit_price_label}}
					</th>
					<th class= "text-center" style=" width: 20% !important;">
						{{$receipt_details->table_subtotal_label}}
					</th>
				</tr>
			</thead>
			<tbody>

				<?php 
			        $tqty = 0;
			        function limit_text($text, $limit) {
			        if (str_word_count($text, 0) > $limit) {
			            $words = str_word_count($text, 2);
			            $pos = array_keys($words);
			            $text = substr($text, 0, $pos[$limit]);
			        }
			        return $text;
			      }
         		?>
				@foreach($receipt_details->lines as $line)
					<tr style=" font-size: 12px !important">
						<td class="text-center">
							<strong>{{$loop->iteration}}</strong>
						</td>
						<td style="word-break: break-all;" >
                             <strong>{{ limit_text($line['name'], 3)  }}
                           
                            @if(!empty($line['product_custom_fields'])), {{$line['product_custom_fields']}} @endif
                            @if(!empty($line['sell_line_note']))({{$line['sell_line_note']}}) @endif
                            @if(!empty($line['lot_number']))<br> {{$line['lot_number_label']}}:  {{$line['lot_number']}} @endif 
                            @if(!empty($line['product_expiry'])), {{$line['product_expiry_label']}}:  {{$line['product_expiry']}} @endif </strong>
                        </td>



						<td class="text-right">
							<strong><?php $tqty += $line['quantity']; ?>
							{{$line['quantity']}} {{$line['units']}}</strong>
						</td>
						<td class="text-right">
							<strong>{{$line['unit_price_inc_tax']}}</strong>
						</td>
						<td class="text-right">
							<strong>{{$line['line_total']}}</strong>
						</td>
					</tr>
					@if(!empty($line['modifiers']))
						@foreach($line['modifiers'] as $modifier)
							<tr>
								<td class="text-center">
									&nbsp;
								</td>
								<td>
		                            {{$modifier['name']}}
		                            @if(!empty($modifier['sub_sku'])), {{$modifier['sub_sku']}} @endif 
		                            @if(!empty($modifier['sell_line_note']))({{$modifier['sell_line_note']}}) @endif 
		                        </td>

								@if($receipt_details->show_cat_code == 1)
			                        <td>
			                        	@if(!empty($modifier['cat_code']))
			                        		{{$modifier['cat_code']}}
			                        	@endif
			                        </td>
			                    @endif

								<td class="text-right">
									{{$modifier['quantity']}} {{$modifier['units']}}
								</td>
								<td class="text-right">
									{{$modifier['unit_price_exc_tax']}}
								</td>
								<td class="text-right">
									{{$modifier['line_total']}}
								</td>
							</tr>
						@endforeach
					@endif
				@endforeach

				@php
					$lines = count($receipt_details->lines);
				@endphp

				@for ($i = $lines; $i < 7; $i++)
    				
				@endfor

			</tbody>
		</table>
	</div>
	</center>
</div>
<hr style="border: 1px dashed" />


<div class="row invoice-info " style="page-break-inside: avoid !important">

	<div class="col-md-6 invoice-col width-50" style="font-size: 12px !important">
		<table class="table-no-side-cell-border table-no-top-cell-border width-100">
			<tbody>
				<tr class="">
					<th style="width:50%">
						{!! $receipt_details->subtotal_label !!}
					</th>
					<td class="text-right">
						{{$receipt_details->subtotal}}
					</td>
				</tr>
				<!-- Shipping Charges -->
				@if(!empty($receipt_details->shipping_charges))
					<tr class="">
						<th style="width:50%">
							{!! $receipt_details->shipping_charges_label !!}
						</th>
						<td class="text-right">
							{{$receipt_details->shipping_charges}}
						</td>
					</tr>
				@endif

				<!-- Discount -->
				@if( !empty($receipt_details->discount) )
					<tr class="">
						<th>
							{!! $receipt_details->discount_label !!}
						</th>

						<td class="text-right">
							(-) {{$receipt_details->discount}}
						</td>
					</tr>
				@endif
				
				<!-- Total Paid-->
			      @if(!empty($receipt_details->total_paid))
			        <tr>
			          <th>
			            {!! $receipt_details->total_paid_label !!}:
			          </th>
			          <td class="text-right">
			            {{$receipt_details->total_paid}}
			          </td>
			        </tr>
			      @endif

			      <!-- Total Due-->
				@if(!empty($receipt_details->total_due))
					<tr>
			          <th>
			            {!! $receipt_details->total_due_label !!}:
			          </th>
			          <td class="text-right">
			            {{$receipt_details->total_due}}
			          </td>
			        </tr>
				@endif

				@if(!empty($receipt_details->all_due))
					<tr>
			          <th>
			            {!! $receipt_details->all_bal_label !!}:
			          </th>
			          <td class="text-right">
			            {{$receipt_details->all_due}}
			          </td>
			        </tr>
				@endif


	      		<tr>
		              <th class="text-left">
		                Total Quantity:
		              </th>

		              <td class="text-right">
		               <?php echo $tqty; ?>
		              </td>
	            </tr>

			</tbody>
        </table>
	</div>
	<div class="col-md-6 invoice-col width-50" style="font-size: 12px !important">
		<table class="table-no-side-cell-border table-no-top-cell-border width-100">
			<tbody>

			       @if(!empty($receipt_details->payments))
			        @foreach($receipt_details->payments as $payment)

			          <tr>
			            <th style="width:60%">{{$payment['method']}}:</th>
			            <td class="text-right">{{$payment['amount']}}</td>
			          </tr>
			        @endforeach
			      @endif


			</tbody>
        </table>
	</div>
</div>
<hr style="border: 1px dashed" />
	</td>
		</tr>
	</tbody>
</table>

<div class="text-center" style="margin-top: -20px; margin-bottom: 10px;">
 <b> Thank you! Come Again.
</div>

</div>