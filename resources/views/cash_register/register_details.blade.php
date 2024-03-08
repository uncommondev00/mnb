<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">

    <div class="modal-header">
      <button type="button" class="close no-print" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h3 class="modal-title">@lang( 'cash_register.register_details' ) ( {{ \Carbon::createFromFormat('Y-m-d H:i:s', $register_details->open_time)->format('jS M, Y h:i A') }} - {{ \Carbon::now()->format('jS M, Y h:i A') }})</h3>
    </div>

    <div class="modal-body">
      <div class="row">
        <div class="col-sm-6">
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

        <!--Denomination Section-->
          
          <div class="col-sm-6">
          <table class="table">
            <tr>
              <td>
                Denomination 1000:
              </td>
              <td>
                <span class="" >{{ $register_details->denom1000 }}</span>
              </td>
              @php
                $denom1000 =  $register_details->denom1000 * 1000;
              @endphp
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $denom1000 }}</span>
              </td>

            </tr>

            <tr>
              <td>
                Denomination 500:
              </td>
              <td>
                <span class="" >{{ $register_details->denom500 }}</span>
              </td>
              @php
                $denom500 =  $register_details->denom500 * 500;
              @endphp
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $denom500 }}</span>
              </td>
            </tr>

            <tr>
               <td>
                Denomination 200:
              </td>
              <td>
                <span class="" >{{ $register_details->denom200 }}</span>
              </td>
              @php
                $denom200 =  $register_details->denom200 * 200;
              @endphp
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $denom200 }}</span>
              </td>
            </tr>

            <tr>
              <td>
                Denomination 100:
              </td>
              <td>
                <span class="" >{{ $register_details->denom100 }}</span>
              </td>
              @php
                $denom100 =  $register_details->denom100 * 100;
              @endphp
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $denom100 }}</span>
              </td>

            </tr>

            <tr>
              <td>
                Denomination 50:
              </td>
              <td>
                <span class="" >{{ $register_details->denom50 }}</span>
              </td>
              @php
                $denom50 =  $register_details->denom50 * 50;
              @endphp
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $denom50 }}</span>
              </td>
            </tr>

           
              <tr>
                  <td>
                  Denomination 20:
                </td>
                <td>
                  <span class="" >{{ $register_details->denom20 }}</span>
                </td>
                @php
                  $denom20 =  $register_details->denom20 * 20;
                @endphp
                <td>
                  <span class="display_currency" data-currency_symbol="true">{{ $denom20 }}</span>
                </td>
              </tr>

            <tr>
              <td>
                Denomination 10:
              </td>
              <td>
                <span class="" >{{ $register_details->denom10 }}</span>
              </td>
              @php
                $denom10 =  $register_details->denom10 * 10;
              @endphp
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $denom10 }}</span>
              </td>
            </tr>

            <tr>
              <td>
                Denomination 5:
              </td>
              <td>
                <span class="" >{{ $register_details->denom5 }}</span>
              </td>
              @php
                $denom5=  $register_details->denom5 * 5;
              @endphp
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $denom5 }}</span>
              </td>
            </tr>

            <tr>
              <td>
                Denomination 1:
              </td>
              <td>
                <span class="" >{{ $register_details->denom1 }}</span>
              </td>
              @php
                $denom1=  $register_details->denom1 * 1;
              @endphp
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $denom1 }}</span>
              </td>
            </tr>

            <tr>
              <td>
                Denomination 25¢:
              </td>
              <td>
                <span class="" >{{ $register_details->denom_25 }}</span>
              </td>
              @php
                $denom_25=  $register_details->denom_25 * .25;
              @endphp
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $denom_25 }}</span>
              </td>
            </tr>

            <tr class="success">
              <th>
                Total Denomination:
              </th>
              <td>
                
              </td>
              <td>
                <span class="display_currency" data-currency_symbol="true" >{{ $register_details->closing_amount }}</span>
              </td>
            </tr>

          </table>
        </div>

      </div>

      @include('cash_register.register_product_details')
      
      <div class="row">
        <div class="col-sm-12">
          <b>@lang('report.user'):</b> {{ $register_details->user_name}}<br>
          <b>Email:</b> {{ $register_details->email}}
        </div>
      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-primary no-print" 
        aria-label="Print" 
          onclick="$(this).closest('div.modal').printThis();">
        <i class="fa fa-print"></i> @lang( 'messages.print' )
      </button>

      <button type="button" class="btn btn-default no-print" 
        data-dismiss="modal">@lang( 'messages.cancel' )
      </button>
    </div>

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->