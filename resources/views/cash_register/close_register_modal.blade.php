<div class="modal-dialog modal-lg no-print" role="document" >
  <div class="modal-content">
    {!! Form::open(['url' => action('CashRegisterController@postCloseRegister'), 'method' => 'post' ]) !!}
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h3 class="modal-title">@lang( 'cash_register.current_register' ) ( {{ \Carbon::createFromFormat('Y-m-d H:i:s', $register_details->open_time)->format('jS M, Y h:i A') }} - {{ \Carbon::now()->format('jS M, Y h:i A') }})</h3>
    </div>


    <div class="modal-body">
      <div class="row">

        <div class="col-sm-12">

          <div class="section" id="section" >
              <center>
                <div class="form-group row" align="center">

                    <div class="col-md-12 text-center " >
                      <div class="col-md-4 text-center " >

                        
                      </div>
                       <div class="col-md-4 text-center " >
                        <b><div id="divCheckPassword" style="color: red"></div></b>
                         <input class="form-control text-center" type="password" name="RNPassword" placeholder="Enter your Pincode here" id="txtConfirmPassword" >
                       </div>
                       <div class="col-md-4 text-center " ></div>
                    </div>  
                </div>

                <div> 
                    <button type="submit" class="btn btn-success" id="verify"  onclick="myFunction();"> Verify </button> 
                </div>
    
                
              </center>
          </div>

          <div id="section_1">
            <div class="col-md-12"><h4 style="color: red;">Instruction:</h4>
                    <b><h5>Fill the corresponding number of bills inside the textbox for every denomination listed on the screen! Type 0 if the corresponding bill is not present!</p><h5>
            </div>
            <center>
              <div class="form-group row " align="center">
                <div class="col-md-12 text-center" style="margin-top: 10px;">
                  <div class="col-md-4">
                    
                  </div>
                  <div class="col-md-4">
                    <div class="col-md-4">
                       {!! Form::label('denom1000', '1000') !!}
                    </div>
                    <div class="col-md-1">
                       {!! Form::label('denom1000', 'x') !!}
                    </div>
                    <div class="col-md-6" >
                      {!! Form::number('denom1000', null, ['onchange'=>"totalise()", 'id' => 'qt1', 'class' => 'form-control input_number', 'required', 'placeholder' => '' ]); !!}
                    </div>
                  </div>
                  <div class="col-md-4 ">
                  <b style="font-size: 20px; color: #00a1ff;">  = Php <span style=" " class="text-center" id="total1" type="text" ></span></b>
                  </div>
                </div>
                
                <div class="col-md-12 text-center" style="margin-top: 10px;">
                  <div class="col-md-4"></div>
                  <div class="col-md-4">
                    <div class="col-md-4">
                       {!! Form::label('denom500', '500') !!}
                    </div>
                    <div class="col-md-1">
                       {!! Form::label('denom500', 'x') !!}
                    </div>
                    <div class="col-md-6">
                      {!! Form::number('denom500', '0', ['onchange'=>"totalise()", 'id' => 'qt2', 'class' => 'form-control input_number', 'required', 'placeholder' => '' ]); !!}
                    </div>
                  </div>
                  <div class="col-md-4">
                   <b style="font-size: 20px; color: #ffee00;">  = Php <span style=" " class="text-center" id="total2" type="text" ></span></b>
                  </div>
                </div>

                <div class="col-md-12 text-center" style="margin-top: 10px;">
                  <div class="col-md-4"></div>
                  <div class="col-md-4">
                    <div class="col-md-4">
                       {!! Form::label('denom200', '200') !!}
                    </div>
                    <div class="col-md-1">
                       {!! Form::label('denom200', 'x') !!}
                    </div>
                    <div class="col-md-6">
                      {!! Form::number('denom200', '0', ['onchange'=>"totalise()", 'id' => 'qt3', 'class' => 'form-control input_number', 'required', 'placeholder' => '' ]); !!}
                    </div>
                  </div>
                  <div class="col-md-4"></div>
                   <b style="font-size: 20px; color: #00ce6a;">  = Php <span style=" " class="text-center" id="total3" type="text" ></span></b>
                </div>

                 <div class="col-md-12 text-center" style="margin-top: 10px;">
                  <div class="col-md-4"></div>
                  <div class="col-md-4">
                    <div class="col-md-4">
                       {!! Form::label('denom100', '100') !!}
                    </div>
                    <div class="col-md-1">
                       {!! Form::label('denom100', 'x') !!}
                    </div>
                    <div class="col-md-6">
                      {!! Form::number('denom100', '0', ['onchange'=>"totalise()", 'id' => 'qt4', 'class' => 'form-control input_number', 'required', 'placeholder' => '' ]); !!}
                    </div>
                  </div>
                  <div class="col-md-4"></div>
                  <b style="font-size: 20px; color: #995ea5;">  = Php <span style=" " class="text-center" id="total4" type="text" ></span></b>
                </div>

                 <div class="col-md-12 text-center" style="margin-top: 10px;">
                  <div class="col-md-4"></div>
                  <div class="col-md-4">
                    <div class="col-md-4">
                       {!! Form::label('denom50', '50') !!}
                    </div>
                    <div class="col-md-1">
                       {!! Form::label('denom50', 'x') !!}
                    </div>
                    <div class="col-md-6">
                      {!! Form::number('denom50', '0', ['onchange'=>"totalise()", 'id' => 'qt5', 'class' => 'form-control input_number', 'required', 'placeholder' => '' ]); !!}
                    </div>
                  </div>
                  <div class="col-md-4"></div>
                  <b style="font-size: 20px; color: #ff5959;">  = Php <span style=" " class="text-center" id="total5" type="text" ></span></b>
                </div>

                 <div class="col-md-12 text-center" style="margin-top: 10px;">
                  <div class="col-md-4"></div>
                  <div class="col-md-4">
                    <div class="col-md-4">
                       {!! Form::label('denom20', '20') !!}
                    </div>
                    <div class="col-md-1">
                       {!! Form::label('denom20', 'x') !!}
                    </div>
                    <div class="col-md-6">
                      {!! Form::number('denom20', '0', ['onchange'=>"totalise()", 'id' => 'qt6','class' => 'form-control input_number', 'required', 'placeholder' => '' ]); !!}
                    </div>
                  </div>
                  <div class="col-md-4"></div>
                  <b style="font-size: 20px; color: #ffb223;">  = Php <span style=" " class="text-center" id="total6" type="text" ></span></b>
                </div>

                 <div class="col-md-12 text-center" style="margin-top: 10px;">
                  <div class="col-md-4"></div>
                  <div class="col-md-4">
                    <div class="col-md-4">
                       {!! Form::label('denom10', '10') !!}
                    </div>
                    <div class="col-md-1">
                       {!! Form::label('denom10', 'x') !!}
                    </div>
                    <div class="col-md-6">
                      {!! Form::number('denom10', '0', ['onchange'=>"totalise()", 'id' => 'qt7', 'class' => 'form-control input_number', 'required', 'placeholder' => '' ]); !!}
                    </div>
                  </div>
                  <div class="col-md-4"></div>
                  <b style="font-size: 20px; color: #C0C0C0;">  = Php <span style=" " class="text-center" id="total7" type="text" ></span></b>
                </div>

                 <div class="col-md-12 text-center" style="margin-top: 10px;">
                  <div class="col-md-4"></div>
                  <div class="col-md-4">
                    <div class="col-md-4">
                       {!! Form::label('denom5', '5') !!}
                    </div>
                    <div class="col-md-1">
                       {!! Form::label('denom5', 'x') !!}
                    </div>
                    <div class="col-md-6">
                      {!! Form::number('denom5', '0', ['onchange'=>"totalise()", 'id' => 'qt8', 'class' => 'form-control input_number', 'required', 'placeholder' => '' ]); !!}
                    </div>
                  </div>
                  <div class="col-md-4"></div>
                  <b style="font-size: 20px; color: #C0C0C0;">  = Php <span style=" " class="text-center" id="total8" type="text" ></span></b>
                </div>

                <div class="col-md-12 text-center" style="margin-top: 10px;">
                  <div class="col-md-4"></div>
                  <div class="col-md-4">
                    <div class="col-md-4">
                       {!! Form::label('denom1', '1') !!}
                    </div>
                    <div class="col-md-1">
                       {!! Form::label('denom1', 'x') !!}
                    </div>
                    <div class="col-md-6">
                      {!! Form::number('denom1', '0', ['onchange'=>"totalise()", 'id' => 'qt9', 'class' => 'form-control input_number', 'required', 'placeholder' => '' ]); !!}
                    </div>
                  </div>
                  <div class="col-md-4"></div>
                  <b style="font-size: 20px; color: #C0C0C0;">  = Php <span style=" " class="text-center" id="total9" type="text" ></span></b>
                </div>

                <div class="col-md-12 text-center" style="margin-top: 10px;">
                  <div class="col-md-4"></div>
                  <div class="col-md-4">
                    <div class="col-md-4">
                       {!! Form::label('denom_25', '25¢') !!}
                    </div>
                    <div class="col-md-1">
                       {!! Form::label('denom_25', 'x') !!}
                    </div>
                    <div class="col-md-6">
                      {!! Form::number('denom_25', '0', ['onchange'=>"totalise()", 'id' => 'qt10', 'class' => 'form-control input_number', 'required', 'placeholder' => '' ]); !!}
                    </div>
                  </div>
                  <div class="col-md-4"></div>
                  <b style="font-size: 20px; color: #cd7f32;">  = Php <span style=" " class="text-center" id="total10" type="text" ></span></b>
                </div>
        
              </div>
            </center>
          </div>
    
        <div id="section_2">
          <table class="table">
            <tr>
              <td>
                @lang('cash_register.cash_in_hand'):
              </td>
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $register_details->cash_in_hand }}</span>
              </td>
            </tr>

            <tr>
              <td>
                @lang('cash_register.cash_payment'):
              </td>
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_cash }}</span>
              </td>
            </tr>

            <tr>
              <td>
                Points Payment:
              </td>
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $register_details->points }}</span>
              </td>
            </tr>

            <tr>
              <td>
                @lang('cash_register.checque_payment'):
              </td>
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_cheque }}</span>
              </td>
            </tr>
            <tr>
              <td>
                @lang('cash_register.card_payment'):
              </td>
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_card }}</span>
              </td>
            </tr>
            <tr>
              <td>
                @lang('cash_register.bank_transfer'):
              </td>
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_bank_transfer }}</span>
              </td>
            </tr>
            @if(config('constants.enable_custom_payment_1'))
              <tr>
                <td>
                  @lang('lang_v1.custom_payment_1'):
                </td>
                <td>
                  <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_custom_pay_1 }}</span>
                </td>
              </tr>
            @endif
            @if(config('constants.enable_custom_payment_2'))
              <tr>
                <td>
                  @lang('lang_v1.custom_payment_2'):
                </td>
                <td>
                  <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_custom_pay_2 }}</span>
                </td>
              </tr>
            @endif
            @if(config('constants.enable_custom_payment_3'))
              <tr>
                <td>
                  @lang('lang_v1.custom_payment_3'):
                </td>
                <td>
                  <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_custom_pay_3 }}</span>
                </td>
              </tr>
            @endif
            <tr>
              <td>
                @lang('cash_register.other_payments'):
              </td>
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_other }}</span>
              </td>
            </tr>
            <tr>
              <td>
                @lang('cash_register.total_sales'):
              </td>
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_sale }}</span>
              </td>
            </tr>
            <tr class="success">
              <th>
                @lang('cash_register.total_refund')
              </th>
              <td>
                <b><span class="display_currency" data-currency_symbol="true">{{ $register_details->total_refund }}</span></b><br>
                <small>
                @if($register_details->total_cash_refund != 0)
                  Cash: <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_cash_refund }}</span><br>
                @endif
                @if($register_details->total_cheque_refund != 0) 
                  Cheque: <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_cheque_refund }}</span><br>
                @endif
                @if($register_details->total_card_refund != 0) 
                  Card: <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_card_refund }}</span><br> 
                @endif
                @if($register_details->total_bank_transfer_refund != 0)
                  Bank Transfer: <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_bank_transfer_refund }}</span><br>
                @endif
                @if(config('constants.enable_custom_payment_1') && $register_details->total_custom_pay_1_refund != 0)
                    @lang('lang_v1.custom_payment_1'): <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_custom_pay_1_refund }}</span>
                @endif
                @if(config('constants.enable_custom_payment_2') && $register_details->total_custom_pay_2_refund != 0)
                    @lang('lang_v1.custom_payment_2'): <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_custom_pay_2_refund }}</span>
                @endif
                @if(config('constants.enable_custom_payment_3') && $register_details->total_custom_pay_3_refund != 0)
                    @lang('lang_v1.custom_payment_3'): <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_custom_pay_3_refund }}</span>
                @endif
                @if($register_details->total_other_refund != 0)
                  Other: <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_other_refund }}</span>
                @endif
                </small>
              </td>
            </tr>
            <tr class="success">
              <th>
                @lang('cash_register.total_cash')
              </th>
              <td>
                <b><span class="display_currency" data-currency_symbol="true">{{ $register_details->cash_in_hand + $register_details->total_cash - $register_details->total_cash_refund }}</span></b>
              </td>
            </tr>
          </table>
        </div>

        </div>
      </div>

    <div id="section_3">
      @include('cash_register.register_product_details')
    </div>

    <div id="section_4">
      <div class="row">
        <div class="col-sm-4">
          <div class="form-group">
            {!! Form::label('closing_amount', __( 'cash_register.total_cash' ) . ':*') !!}
              {!! Form::text('closing_amount', null, ['onchange'=>"cashTotal()", 'id' => 'ctotal', 'class' => 'form-control input_number', 'required', 'placeholder' => __( 'cash_register.total_cash' ), 'readonly' ]); !!}
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            {!! Form::label('total_card_slips', __( 'cash_register.total_card_slips' ) . ':*') !!} @show_tooltip(__('tooltip.total_card_slips'))
              {!! Form::number('total_card_slips', $register_details->total_card_slips, ['class' => 'form-control', 'required', 'placeholder' => __( 'cash_register.total_card_slips' ), 'min' => 0 ]); !!}
          </div>
        </div> 
        <div class="col-sm-4">
          <div class="form-group">
            {!! Form::label('total_cheques', __( 'cash_register.total_cheques' ) . ':*') !!} @show_tooltip(__('tooltip.total_cheques'))
              {!! Form::number('total_cheques', $register_details->total_cheques, ['class' => 'form-control', 'required', 'placeholder' => __( 'cash_register.total_cheques' ), 'min' => 0 ]); !!}
          </div>
        </div> 
        <div class="col-sm-12">
          <div class="form-group">
            {!! Form::label('closing_note', __( 'cash_register.closing_note' ) . ':') !!}
              {!! Form::textarea('closing_note', null, ['class' => 'form-control', 'placeholder' => __( 'cash_register.closing_note' ), 'rows' => 3 ]); !!}
          </div>
        </div>
      </div>
      </div>


    </div><!--modal-body-->
    <div class="modal-footer">
      <button type="button" id="prnt" class="btn btn-primary no-print" 
        aria-label="Print"  style="display: none;">
      </button>
      <button type="button" id="Button" class="btn btn-primary" disabled>OK</button>
      <button id="submit" type="submit" class="btn btn-primary" data-keyboard="false">@lang( 'cash_register.close_register' )</button>
    </div>
    {!! Form::close() !!}
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script  type="text/javascript">
        $(document).ready(function () {
            $("form").submit(function () {
                denom_25 = $("input[name='denom_25']").val();
                denom1 = $("input[name='denom1']").val();
                denom5 = $("input[name='denom5']").val();
                denom10 = $("input[name='denom10']").val();
                denom20 = $("input[name='denom20']").val();
                denom50 = $("input[name='denom50']").val();
                denom100 = $("input[name='denom100']").val();
                denom200 = $("input[name='denom200']").val();
                denom500 = $("input[name='denom500']").val();
                denom1000 = $("input[name='denom1000']").val();
                total = $("input[name='closing_amount']").val();

                $.ajax({
                    method: 'GET',
                    url: "{{action('DenominationController@getDenonimation') }}",
                    data: { denom_25 : denom_25, denom1 : denom1, denom5 : denom5, denom10 : denom10, denom20 : denom20, denom50 : denom50, denom100 : denom100, denom200 : denom200, denom500 : denom500, denom1000 : denom1000, total : total },
                    success: function(result) {
                       $('#receipt_section').html(result);
                      window.print();
                    },
                });
            })
        });
    </script>

<script>
    
    $(document).on('shown.bs.modal', function () {
    $('#txtConfirmPassword').focus();
    })  


      var pins = [{{config('app.security')}}];

      function pincode(pin) {
        return pin == document.getElementById("txtConfirmPassword").value;
      }

      function myFunction() {
        if (document.getElementById("divCheckPassword").innerHTML = pins.find(pincode) == undefined){
              document.getElementById("divCheckPassword").innerHTML = "Incorrect Pincode!";
              document.getElementById("txtConfirmPassword").value = "";

         }else{
           document.getElementById("divCheckPassword").innerHTML = "";
             $("#section_1").show("#section_1"), $("#section_4").show("#section_4"), $("#section").hide("#section");
             $("#submit").show();
             document.getElementById('Button').disabled = false;
             document.getElementById('prnt').disabled = false;
             //print();
          }
      }

      function totalise() {    
    var qtd1   = document.getElementById('qt1').value;
    var price1  = 1000;
    var result1 = document.getElementById("total1");
    result1.innerHTML = price1 * qtd1;

    var qtd2   = document.getElementById('qt2').value;
    var price2  = 500;
    var result2 = document.getElementById("total2");
    result2.innerHTML = price2 * qtd2;

    var qtd3   = document.getElementById('qt3').value;
    var price3  = 200;
    var result3 = document.getElementById("total3");
    result3.innerHTML = price3 * qtd3;

    var qtd4   = document.getElementById('qt4').value;
    var price4  = 100;
    var result4 = document.getElementById("total4");
    result4.innerHTML = price4 * qtd4;

    var qtd5   = document.getElementById('qt5').value;
    var price5  = 50;
    var result5 = document.getElementById("total5");
    result5.innerHTML = price5 * qtd5;

    var qtd6   = document.getElementById('qt6').value;
    var price6  = 20;
    var result6 = document.getElementById("total6");
    result6.innerHTML = price6 * qtd6;

    var qtd7   = document.getElementById('qt7').value;
    var price7  = 10;
    var result7 = document.getElementById("total7");
    result7.innerHTML = price7 * qtd7;

    var qtd8   = document.getElementById('qt8').value;
    var price8  = 5;
    var result8 = document.getElementById("total8");
    result8.innerHTML = price8 * qtd8;

    var qtd9   = document.getElementById('qt9').value;
    var price9  = 1;
    var result9 = document.getElementById("total9");
    result9.innerHTML = price9 * qtd9;

    var qtd10   = document.getElementById('qt10').value;
    var price10  = .25;
    var result10 = document.getElementById("total10");
    result10.innerHTML = price10 * qtd10;

    var a= +document.getElementById("total1").innerHTML;
    var b= +document.getElementById("total2").innerHTML;
    var c= +document.getElementById("total3").innerHTML;
    var d= +document.getElementById("total4").innerHTML;
    var e= +document.getElementById("total5").innerHTML;
    var f= +document.getElementById("total6").innerHTML;
    var g= +document.getElementById("total7").innerHTML;
    var h= +document.getElementById("total8").innerHTML;
    var i= +document.getElementById("total9").innerHTML;
    var j= +document.getElementById("total10").innerHTML;

    if(!isNaN(a) && !isNaN(b) && !isNaN(c) && !isNaN(d) && !isNaN(e) && !isNaN(f) && !isNaN(g) && !isNaN(h) && !isNaN(i) && !isNaN(j)){
   document.getElementById('ctotal').value = (a+b+c+d+e+f+g+h+i+j);
}
    

}
      
      function cashTotal(){

        var sum1 = document.getElementById("total10").value;
        var sum2 = document.getElementById("total9").value;

        document.getElementById('ctotal').value = sum1 + sum2;

      }

          $(document).ready(function(){

            $("#qt1").keypress(totalise);
            $("#ctotal").keypress(cashTotal);
            $("#section_1").hide();
             $("#btn_section1").hide();
            $("#section_2").hide();
            $(".btn_section2").hide();
            $("#section_3").hide();
            $("#section_4").hide();
            $("#submit").hide();
            $("#Button").hide();
            
        $("#Button").click(function(){
             $("#section").hide();
             $("#Button").hide();
            $("#section_1").hide();
            $("#section_4").hide();
             $("#section_2").show();
             $("#section_3").show();
             $("#submit").show();
             
          });


         });


</script>