<div class="modal-header">
    <button type="button" class="close no-print" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <!-- <h4 class="modal-title" id="modalTitle"> @lang('purchase.purchase_details') (<b>@lang('purchase.ref_no'):</b> #{{ $purchase->ref_no }})
    </h4> -->

    <h4 class="modal-title" id="modalTitle"><strong>{{ $purchase->business->name }}</strong></h4>
    <p>@if(!empty($purchase->location->city) || !empty($purchase->location->state) ||!empty($purchase->location->country))
          {{implode(',', array_filter([$purchase->location->city, $purchase->location->state, $purchase->location->country]))}}<br>
      @endif

      Tel No. :@if(!empty($purchase->location->mobile))
          @lang('contact.mobile'): {{$purchase->location->mobile}}
        @endif
    </p>
      
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-sm-12">
      <p class="pull-right"><b>@lang('messages.date'):</b> {{ @format_date($purchase->transaction_date) }}</p>
    </div>
  </div>
  <div class="row invoice-info">
    <div class="col-sm-6 invoice-col">

      <strong>Invoice # : #{{ $purchase->ref_no }} </strong><br>
      <strong>Supplier Code : </strong><br>
      <strong>Supplier Name : {{ $purchase->contact->name }}</strong><br>

    </div>
  </div>

  <br>
  <div class="row">
    <div class="col-sm-12 col-xs-12">
      <div class="table-responsive">
        <table class="table bg-gray">
          <thead>
            <tr class="bg-green">
              <th width="100px">Barcode</th>
              <th>Description</th>
              <th width="100px">Qty</th>
              <th width="100px">Price</th>
              <th width="100px">Amount</th>
            </tr>
          </thead>
          @php 
            $total_before_tax = 0.00;
          @endphp
          @foreach($purchase->purchase_lines as $purchase_line)
            <tr>
              <td>{{ $purchase_line->product->sku }}</td>
              <td>
                {{ $purchase_line->product->name }}
                 @if( $purchase_line->product->type == 'variable')
                  - {{ $purchase_line->variations->product_variation->name}}
                  - {{ $purchase_line->variations->name}}
                 @endif
              </td>
              <td><span class="display_currency" data-is_quantity="true" data-currency_symbol="false">{{ $purchase_line->quantity }}</span> @if(!empty($purchase_line->sub_unit)) {{$purchase_line->sub_unit->short_name}} @else {{$purchase_line->product->unit->short_name}} @endif</td>
              
              <td><span class="display_currency" data-currency_symbol="true">{{ $purchase_line->purchase_price_inc_tax }}</span></td>

              <td><span class="display_currency" data-currency_symbol="true">{{ $purchase_line->purchase_price_inc_tax * $purchase_line->quantity }}</span></td>
            </tr>
          @endforeach
        </table>
      </div>
    </div>
  </div>

</div>
<div class="modal-footer">
  <div class="col-sm-12 text-right">
    <div class="col-sm-6">
      <p> Total Qty:  <span class="display_currency" >{{ \App\Product::sum_qty($purchase->id)}}</span></p>
    </div>
    <div class="col-sm-6">
      <p> Total Amount:  <span class="display_currency" data-currency_symbol="true">{{ $purchase->final_total }}</span></p>
    </div>
    
  </div><br>
  <div class="col-sm-12 text-center">
    <p> < < < Nothing Follows > > > </p>
  </div><br>

  <div class="row">
    <div class="col-sm-12 col-xs-12">
      <div class="table-responsive">
        <table class="table bg-gray">
          <thead>
            <tr>
              <th class="text-center"><p>_______________________________</p> Prepared by:</th>
              <th class="text-center"><p>_______________________________</p> Received by:</th>
              <th class="text-center"><p>_______________________________</p> Approved by:</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>

 
</div>