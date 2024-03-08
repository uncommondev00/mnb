<style>
.pos-container{
  border:1px solid;
    padding:2mm;
  margin: 0 auto;
  width: 76mm;
  background: #FFF;
  font-family: MS Gothic !important; 
}
</style>


<!-- business information here -->
<div class="pos-container">

<div class="row">

  <!-- Logo -->
  @if(!empty($receipt_details->logo))
    <img src="{{$receipt_details->logo}}" class="img img-responsive center-block">
  @endif

  <!-- Header text -->
  @if(!empty($receipt_details->header_text))
    <div class="col-xs-12">
      {!! $receipt_details->header_text !!}
    </div>
  @endif

  <!-- business information here -->
  <div class="col-xs-12 text-center">
    <h2 class="text-center">
      <!-- Shop & Location Name  -->
      @if(!empty($receipt_details->display_name))
        {{$receipt_details->display_name}}
      @endif
    </h2>

    <!-- Address -->
    <p>
    @if(!empty($receipt_details->address))
        <small class="text-center">
        {!! $receipt_details->address !!}
        </small>
    @endif
    @if(!empty($receipt_details->contact))
      <br/>{{ $receipt_details->contact }}
    @endif  
    @if(!empty($receipt_details->contact) && !empty($receipt_details->website))
      , 
    @endif
    @if(!empty($receipt_details->website))
      {{ $receipt_details->website }}
    @endif
    @if(!empty($receipt_details->location_custom_fields))
      <br>{{ $receipt_details->location_custom_fields }}
    @endif
    </p>
    <p>
    @if(!empty($receipt_details->sub_heading_line1))
      {{ $receipt_details->sub_heading_line1 }}
    @endif
    @if(!empty($receipt_details->sub_heading_line2))
      <br>{{ $receipt_details->sub_heading_line2 }}
    @endif
    @if(!empty($receipt_details->sub_heading_line3))
      <br>{{ $receipt_details->sub_heading_line3 }}
    @endif
    @if(!empty($receipt_details->sub_heading_line4))
      <br>{{ $receipt_details->sub_heading_line4 }}
    @endif    
    @if(!empty($receipt_details->sub_heading_line5))
      <br>{{ $receipt_details->sub_heading_line5 }}
    @endif
    </p>
    <p>
    @if(!empty($receipt_details->tax_info1))
      <b>{{ $receipt_details->tax_label1 }}</b> {{ $receipt_details->tax_info1 }}
    @endif

    @if(!empty($receipt_details->tax_info2))
      <b>{{ $receipt_details->tax_label2 }}</b> {{ $receipt_details->tax_info2 }}
    @endif
    </p>

    <!-- Title of receipt -->
    @if(!empty($receipt_details->invoice_heading))
      <h3 class="text-center">
        {!! $receipt_details->invoice_heading !!}
      </h3>
    @endif

    <!-- Invoice  number, Date  -->
    <p style="width: 100% !important" class="word-wrap">
      <span class="pull-left text-left word-wrap">
        @if(!empty($receipt_details->invoice_no_prefix))
          <b>{!! $receipt_details->invoice_no_prefix !!}</b>
        @endif
        {{$receipt_details->invoice_no}}

        <!-- Table information-->
            @if(!empty($receipt_details->table_label) || !empty($receipt_details->table))
              <br/>
          <span class="pull-left text-left">
            @if(!empty($receipt_details->table_label))
              <b>{!! $receipt_details->table_label !!}</b>
            @endif
            {{$receipt_details->table}}

            <!-- Waiter info -->
          </span>
            @endif

        <!-- customer info -->
        @if(!empty($receipt_details->customer_name))
          <br/>
          <b>{{ $receipt_details->customer_label }}:</b> {{ $receipt_details->customer_name }} <br>
        @endif


        @if(!empty($receipt_details->sales_person_label))
          <br/>
          <b>{{ $receipt_details->sales_person_label }}</b> {{ $receipt_details->sales_person }}
        @endif
      </span>

      <span class="pull-left">
        <b>{{$receipt_details->date_label}}</b> {{$receipt_details->invoice_date}}
        
        <!-- Waiter info -->
        @if(!empty($receipt_details->service_staff_label) || !empty($receipt_details->service_staff))
              <br/>
          @if(!empty($receipt_details->service_staff_label))
            <b>{!! $receipt_details->service_staff_label !!}</b>
          @endif
          {{$receipt_details->service_staff}}
            @endif
      </span>
    </p>
  </div>
  <!-- /.col -->
</div>

<hr style="margin-bottom: -20px !important; border: 1px dashed"/>


<div class="row" s>
  <div class="col-xs-12">
    <br/>
    <table class="table table-condensed">
      <thead>
        <tr>
          <th style="width: 70% !important; ">Item</th>
          <th style="width: 10% !important;">Qty</th>
          <th style="width: 20% !important; ">Price</th>
          <th style="width: 20% !important; ">{{$receipt_details->table_subtotal_label}}</th>
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


        @forelse($receipt_details->lines as $line)
          <tr>
            <td style="word-break: break-all;">
                {{ limit_text($line['name'], 3)  }}
            </td>

           <?php 
             $qty_explode = explode('.',trim($line['quantity']));
             $tqty += $line['quantity']; 
           ?>

            <td class="text-left">{{ $qty_explode[0] }}{{$line['units']}} </td>
            <td class="text-right">{{$line['unit_price_inc_tax']}}</td>
            <td class="text-right">{{$line['line_total']}}   </td>
          </tr>
          @if(!empty($line['modifiers']))
            @foreach($line['modifiers'] as $modifier)
              <tr>
                <td>
                                {{$modifier['name']}} {{$modifier['variation']}} 
                                @if(!empty($modifier['sub_sku'])), {{$modifier['sub_sku']}} @endif @if(!empty($modifier['cat_code'])), {{$modifier['cat_code']}}@endif
                                @if(!empty($modifier['sell_line_note']))({{$modifier['sell_line_note']}}) @endif 
                            </td>
                <td> {{ $modifier['quantity']}} {{$modifier['units']}} </td>
                <td>{{$modifier['unit_price_inc_tax']}}</td>
                <td>{{$modifier['line_total']}} </td>
              </tr>
            @endforeach
          @endif
        @empty
          <tr>
            <td colspan="4">&nbsp;</td>
          </tr>
        @endforelse
       <?php //echo $sum; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="row" >


  <div class="col-md-12"><hr style="border: 1px dashed; margin-top: -20px !important"/></div>

  <div class="col-md-12" style="margin-top: -20px !important; margin-bottom: -20px !important">

    <table class="table table-condensed ">

         <!-- Subtotal-->
      @if(!empty($receipt_details->total_paid))
        <tr>
          <th>
            {!! $receipt_details->subtotal_label !!}
          </th>
          <td class="text-right">
            {{$receipt_details->subtotal}}
          </td>
        </tr>
      @endif

      <!-- Shipping Charges -->
          @if(!empty($receipt_details->shipping_charges))
            <tr>
              <th style="">
                {!! $receipt_details->shipping_charges_label !!}:
              </th>
              <td class="text-right">
                (+){{$receipt_details->shipping_charges}}
              </td>
            </tr>
          @endif

           <!-- Discount -->
          @if( !empty($receipt_details->discount) )
            <tr>
              <th class="width-40"> 
                {!! $receipt_details->discount_label !!}
              </th>

              <td class="text-right">
                (-){{$receipt_details->discount}}
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

       @if(!empty($receipt_details->payments))
        @foreach($receipt_details->payments as $payment)

          <tr>
            <th class="text-left">{{$payment['method']}}</th>
            <td class="text-right">{{$payment['amount']}}</td>
          </tr>
        @endforeach
      @endif

      <tr>
              <th class="text-left">
                Total Quantity:
              </th>

              <td class="text-right">
               <?php echo $tqty; ?>
              </td>
            </tr>

    </table>

  </div>

    <div class="col-md-12"><hr style="border: 1px dashed; margin-top: -1px !important"/></div>

  <div class="col-md-12" style="margin-top: -20px !important; margin-bottom: -20px !important">

    <table class="table table-condensed ">
      
          <!--VATABLE-->
          <tr>
            <th>
              Vatable:
            </th>
            <td class="text-right">
              <?php
              //total paid
              $starr = explode(' ',trim($receipt_details->total_paid));
              $vatabledivisor = 1.12;
              //if no discount vatable is equal to total paid
              if(!empty($receipt_details->discount)){
                $disarr = explode(' ',trim($receipt_details->discount));
                 $amtdiscount = str_replace(',', '', $disarr[1]);

                 //$vatable = $starr[1]-$discount;
                $amountvatable =  str_replace(',', '', $starr[1]);
                $vatable =  ($amountvatable - $amtdiscount) / $vatabledivisor;
                $vat = $vatable * 0.12;
              }else{
                
                $amountvatable =  str_replace(',', '', $starr[1]);
                $vatable =  $amountvatable / $vatabledivisor;
                $vat = $vatable * 0.12;
              }
             // $a = "1,000,000,000.05";
            
              //var_dump($amountvatable);
              //$starr[0]. ' '.
             $finalvatable =  number_format((float)$vatable, 2, '.', '');
             //var_dump($finalvatable);
            $fvat = number_format($finalvatable, 2, '.', ',');

            echo $starr[0]. ' '. $fvat;

//$number = 10000000234.56;

//echo number_format($number, 2, '.', ',');
               ?>
            </td>

          </tr>

          <!--VAT@12%-->
          <tr>
            <th>
              VAT@12%:
            </th>
            <td class="text-right">
              <?php

              $finalvat =  number_format((float)$vat, 2, '.', '');

              $tvat = number_format($finalvat, 2, '.', ',');

             echo $starr[0]. ' '. $tvat;
              
           ?>
            </td>
          </tr>
    </table>
  </div>
</div>

 <div class="col-12" style="margin-top: -20px !important; margin-bottom: -15px !important"><hr style="border: 1px dashed"/></div>

 <div class="text-center" style="margin-top: -20px; margin-bottom: 10px;">
 <b> THESE SERVES AS AN <br> INVOICE</b><br/>
 <b> THANK YOU! COME AGAIN <br> This Receipt is Valid until</b><br/>
		<b>
		  	<?php
		    $date = $receipt_details->invoice_date;
		    echo date('Y-m-d', strtotime($date. ' + 2 months'));
			?>	
		</b><br/>
 <b> For return and exchange item <br> must be within 7 days from </b><br/>
 <b> Date of Purchase <br> No Receipt, No Exchange </b>
</div>



	

</div>