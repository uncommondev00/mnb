<style>
.pos-container{
  margin: 0 auto;
  width: 58mm;
  background: #FFF;
  font-size: 10px ;
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
    <h5 class="text-center">
      <!-- Shop & Location Name  -->
      @if(!empty($receipt_details->display_name))
        {{$receipt_details->display_name}}
      @endif
    </h5>

    <!-- Address -->
    <p style="font-size: 12px !important;">
    @if(!empty($receipt_details->address))
        <small class="text-center">
        {!! $receipt_details->address !!}
        </small>
    @endif
    @if(!empty($receipt_details->contact))
    <small class="text-center">
      <br/>{{ $receipt_details->contact }}
    </small>
    @endif  
    @if(!empty($receipt_details->contact) && !empty($receipt_details->website))
    @endif
    @if(!empty($receipt_details->website))
    <small class="text-center">
      {{ $receipt_details->website }}
    </small>
    @endif
    @if(!empty($receipt_details->location_custom_fields))
    <small class="text-center">
      <br>{{ $receipt_details->location_custom_fields }}
    </small>
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
      <h5 class="text-center">
        {!! $receipt_details->invoice_heading !!}
      </h5>
    @endif

    <!-- Invoice  number, Date  -->
    <p style="width: 100% !important" class="word-wrap">

      <span class="pull-left">
        <b>{{$receipt_details->date_label}}:</b> {{$receipt_details->invoice_date}}
        
        <!-- Waiter info -->
        @if(!empty($receipt_details->service_staff_label) || !empty($receipt_details->service_staff))
              <br/>
          @if(!empty($receipt_details->service_staff_label))
            <b>{!! $receipt_details->service_staff_label !!}</b>
          @endif
          {{$receipt_details->service_staff}}
            @endif
      </span>

      <span class="pull-left text-left word-wrap">
        @if(!empty($receipt_details->invoice_no_prefix))
          <b>{!! $receipt_details->invoice_no_prefix !!}:</b>
        @endif
        {{$receipt_details->invoice_no}}
        
        <!--transaction id-->
          <span class="text-left">
            <br>
            <b>Transaction No.:</b>{{$receipt_details->trans_id}}

          </span>

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

        <?php

        $mac_a = config('app.permit_3');
        $mac_b = config('app.permit_4');
        $mac_c = config('app.permit_5');
        $mac_d = config('app.permit_2');

        $ipAdd=$_SERVER['REMOTE_ADDR'];

        //echo "$ipAddress - ";
        $macAdd="";

        #run the external command, break output into lines
        $arp=`arp -a $ipAdd`;
        $macs=explode("\n", $arp);

        #look for the output line describing our IP address
        foreach($macs as $mac)
        {
            $configs=preg_split('/\s+/', trim($mac));
                if ($configs[0]==$ipAdd)
                    {
                       $macAdd=$configs[1]; 
                    }

        }

        // if($macAdd == ""){
        //  echo " <br><b> SN#:</b> 123456789";
        // }elseif($macAdd == $mac_a){
        //   echo " <br><b> SN#:</b> 0987654321";
        // }elseif($macAdd == $mac_b){
        //   echo " <br><b> SN#:</b> 0011223344";
        // }elseif($macAdd == $mac_c){
        //   echo " <br><b> SN#:</b> 5566778899";
        // }elseif($macAdd == $mac_d){
        //   echo " <br><b> SN#:</b> 1010101010";
        // }

    ?>


         @if(!empty($receipt_details->sales_person_label))
         <br/>
          <b>{{ $receipt_details->sales_person_label }}:</b> {{ $receipt_details->sales_person }}
        @endif

        <!-- customer info -->
        @if(!empty($receipt_details->customer_name))
          <br/>
          <b>{{ $receipt_details->customer_label }}:</b> {{ $receipt_details->customer_name }} <br>
        @endif
         @if(!empty($receipt_details->customer_tax_number))
        @if(!empty($receipt_details->customer_tax_label))
          <b>{{ $receipt_details->customer_tax_label }}:</b> {{ $receipt_details->customer_tax_number }}
        @endif
        @endif

       
      </span>

      


    
    </p>
  </div>
  <!-- /.col -->
</div>

<hr style="margin-bottom: -10px !important;  border: 1px dashed"/>


<div class="row">
  <div class="col-xs-12" >
    <br/>
    <table class="table table-condensed" style="margin-left: -5px; font-size: 11px !important; font-family: Arial Narrow !important;">
      <thead>
        <tr>
          <td>Item</td>
          <td>Qty</td>
          <td>Price</td>
          <td hidden="">DISC%</td>
          <td>{{$receipt_details->table_subtotal_label}}</td>
        </tr>
      </thead>
      <tbody>
        <?php 
        $tqty = 0;
        $sbtotal = 0;
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
                <!-- {{ limit_text($line['name'], 3)  }} -->
                {{$line['name']}}
            </td>

           @php
             $qty_explode = explode('.',trim($line['quantity']));
             $tqty += str_replace(',', '', $line['quantity']); 

             $u_p = str_replace(',', '', $line['unit_price_inc_tax']);

             if($line['cat_disc'] != 0)
             {
               $discnt = $line['cat_disc'] / 100;
               $discnted = $u_p * $discnt;

               $disc_price = str_replace(',', '', $line['quantity']) * ($u_p - $discnted);
             }
             else
             {
               $disc_price = str_replace(',', '', $line['quantity']) * $u_p;
             }

             $sbtotal += $disc_price; 
              
           @endphp

            <td class="text-left">{{ $qty_explode[0] }}{{$line['units']}} </td>
            <td class="text-left">{{$line['unit_price_inc_tax']}}</td>
            <td class="text-left" hidden="">{{$line['cat_disc']}}</td>
            <td style="width: 10px;" class="text-left" >{{number_format($disc_price, 2)}}   </td>
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
                <td >{{$modifier['unit_price_inc_tax']}}</td>
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

    <table class="table table-condensed " style="font-size: 9px !important;">

         <!-- Subtotal-->
      @if(!empty($receipt_details->total_paid))
        <tr>
          <th>
            {!! $receipt_details->subtotal_label !!}
          </th>
          <td class="text-left">
            Php {{number_format($sbtotal, 2)}}
          </td>
        </tr>
      @endif

      <!-- Shipping Charges -->
          @if(!empty($receipt_details->shipping_charges))
            <tr>
              <th style="">
                {!! $receipt_details->shipping_charges_label !!}:
              </th>
              <td class="text-left">
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

              <td class="text-left">


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
          <td class="text-left">
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
                <td class="text-left" >
                  <b>{{$receipt_details->total_due}}</b>
                </td>
              </tr>
        @endif

        @if(!empty($receipt_details->all_due))
          <tr style="background-color: red">
                <th >
                  {!! $receipt_details->all_bal_label !!}:
                </th>
                <td class="text-left">
                  <b>{{$receipt_details->all_due}}</b>
                </td>
              </tr>
        @endif

       @if(!empty($receipt_details->payments))
        @foreach($receipt_details->payments as $payment)

          <tr>
            <th class="text-left">{{$payment['method']}}</th>
            <td class="text-left" style="padding-left: 7px;">{{$payment['amount']}}</td>
          </tr>
        @endforeach
      @endif

      <tr>
              <th class="text-left">
                Total Qty:
              </th>

              <td class="text-left">
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
            <td class="text-left">
              <?php

              $vatable_val = $trans_1;

              $vatable_value = json_decode($vatable_val, true);

              $final_vatable = $vatable_value[0]['vatable'];

              //echo "$final_vatable";

              //total paid get Php sign
              $starr = explode(' ',trim($receipt_details->total_paid));
            
              //if no discount vatable is equal to total paid
             // if(!empty($receipt_details->discount)){
              //  $disarr = explode(' ',trim($receipt_details->discount));
              //  $amtdiscount = str_replace(',', '', $disarr[1]);

              //  $disc = $receipt_details->dis;

             //   $d = $disc/100;

               
             //   $f_vatable =  $final_vatable - ($final_vatable * $d);

                
            //  }else{
                
                $f_vatable =  $final_vatable;
               
            //  }

              $vtable_f =  number_format($f_vatable, 2, '.', ',');
             
            echo $starr[0]. ' '. $vtable_f;
               ?>

            </td>

          </tr>
          
          <!--Vat exempt-->
          <tr>
            <th>
              VAT EXEMPT:
            </th>
            <td class="text-left">
              <?php 

              $vat_exempt_val = $trans_2;

              $vat_exempt_value = json_decode($vat_exempt_val, true);

              $final_vat_exempt = $vat_exempt_value[0]['vat_exempt'];

              //if no discount vatable is equal to total paid
              //if(!empty($receipt_details->discount)){
               // $disarr1 = explode(' ',trim($receipt_details->discount));
               // $amtdiscount = str_replace(',', '', $disarr1[1]);

               // $disc1 = $receipt_details->dis;

               // $d1 = $disc1/100;

               
               // $f_vat_exempt =  $final_vat_exempt - ($final_vat_exempt * $d1);

                
             // }else{
                
                $f_vat_exempt =  $final_vat_exempt;
               
             // }

              $v_ex_f =  number_format($f_vat_exempt, 2, '.', ',');    
                           
              echo $starr[0]. ' '. $v_ex_f;
              ?>
            </td>
          </tr>
           

          <tr>

            <th>
              ZERO RATED:
            </th>
            <td class="text-left">
              <?php 


              $zero_rated_val = $trans_3;

              $zero_rated_value = json_decode($zero_rated_val, true);

              $final_zero_rated = $zero_rated_value[0]['zero_rated'];    
              
              if(empty($final_zero_rated)){
                $final_zero_rated = 0;

                $z_r_f =  number_format($final_zero_rated, 2, '.', ',');
                echo $starr[0]. ' '. $z_r_f;
              }else{
                $z_r_f =  number_format($final_zero_rated, 2, '.', ',');
                echo $starr[0]. ' '. $z_r_f;
              }

              ?>
            </td>

          </tr>

          <!--VAT@12%-->
          <tr>
            <th>
              VAT@12%:
            </th>
            <td class="text-left">

              <?php

              $vat_val = $trans_1;

              $vat_value = json_decode($vat_val, true);

              $final_vat = $vat_value[0]['vat_12'];

              //total paid get Php sign
              $starr = explode(' ',trim($receipt_details->total_paid));

               //if no discount vatable is equal to total paid
            //  if(!empty($receipt_details->discount)){
             //   $disarr2 = explode(' ',trim($receipt_details->discount));
              //  $amtdiscount = str_replace(',', '', $disarr2[1]);

            //    $disc2 = $receipt_details->dis;

             //   $d2 = $disc2/100;

               
             //   $f_vat =  $final_vat - ($final_vat * $d2);

                
            //  }else{
                
                $f_vat =  $final_vat;
               
            //  }
            
              //if no discount vatable is equal to total paid
              
              $v_f =  number_format($f_vat, 2, '.', ',');
              echo $starr[0]. ' '. $v_f;

               ?>

            </td>
          </tr>

          

    </table>
  </div>
</div>

<?php $sc = $receipt_details->customer_name; 

if($sc == "Senior Citizen"){
?>

<div class="col-12" style="margin-top: -20px !important; margin-bottom: -15px !important"><hr style="border: 1px dashed"/></div>
<div class="text-left" style="margin-left: 5px;">
  <label class="text-left">Senoir ID:</label><label class="text-left" style="margin-left: 10px;">{{$receipt_details->s_id}}</label><br>
  <label class="text-left">Name:</label><label class="text-left" style="margin-left: 25px;">{{$receipt_details->s_name}}</label>
  <br>
  <label class="text-left">Address:</label><label class="text-left" style="margin-left: 15px;">{{$receipt_details->s_addr}}</label>
</div>
<?php } ?>

@if($receipt_details->points_status)
<div class="col-12" style="margin-top: -20px !important; margin-bottom: -15px !important"><hr style="border: 1px dashed"/></div>

  <div class="col-12" style="margin-top: -20px !important; margin-bottom: -20px !important">

    <table class="table table-condensed ">
      
          <!--Points Previous-->
          <tr>
            <th>
              Points Previous:
            </th>
            <td class="text-left">
                  {{$receipt_details->points_prev}}

            </td>

          </tr>
          
          <!--Points Redeemed-->
          <tr>
            <th>
              Points Redeemed:
            </th>
            <td class="text-left">
              {{$receipt_details->points_red}}
            </td>
          </tr>
           
          <!--Points Earned-->
          <tr>

            <th>
              Points Earned:
            </th>
            <td class="text-left">
              {{$receipt_details->points_add}}
            </td>

          </tr>

          <!--Points Balance-->
          <tr>
            <th>
              Points Balance:
            </th>
            <td class="text-left">
              {{$receipt_details->points_balance}}
            </td>
          </tr>

          

    </table>
  </div>
@endif

 <div class="col-12" style="margin-top: -20px !important; margin-bottom: -15px !important"><hr style="border: 1px dashed"/></div>

 <div class="text-center" style="margin-top: -10px; margin-bottom: 10px;">
  THESE SERVES AS YOUR<br>
  SALES INVOICE<br/>

  <br>

  THANK YOU! COME AGAIN <br> 
  This Receipt is Valid until<br/>

  <?php
    $date = $receipt_details->invoice_date;
    echo date('Y-m-d', strtotime($date. ' + 2 months'));
  ?>  
  <br/>
  For return and exchange item <br> 
  must be within 7 days from<br/>
  Date of Purchase <br> 
  No Receipt, No Exchange 
</div>



  

</div>