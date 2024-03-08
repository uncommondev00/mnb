
<div class="modal-body">
  <div class="row">
    <div class="col-sm-12">
      <p class="pull-right"><b>@lang('messages.date'):</b> {{ @format_date($purchase->transaction_date) }}</p>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-sm-12 col-xs-12">
      <div class="table-responsive">
        <table class="table bg-gray table-condensed table-bordered">
          <thead>
            <tr class="bg-green">
              <th width="100px">Brand</th>
              <th>Description</th>
              <th width="100px">Qty</th>
              <th width="200px">Note</th>
            </tr>
          </thead>
          @foreach($purchase->purchase_lines as $purchase_line)
            <tr>
              <td>{{ $purchase_line->product->brand->name }}</td>
              <td>
                {{ $purchase_line->product->name }}
                 @if( $purchase_line->product->type == 'variable')
                  - {{ $purchase_line->variations->product_variation->name}}
                  - {{ $purchase_line->variations->name}}
                 @endif
              </td>
              <td><span class="display_currency" data-is_quantity="true" data-currency_symbol="false">{{ $purchase_line->quantity }}</span> @if(!empty($purchase_line->sub_unit)) {{$purchase_line->sub_unit->short_name}} @else {{$purchase_line->product->unit->short_name}} @endif</td>
              <td></td>
             
            </tr>
          @endforeach
        </table>
      </div>
    </div>
  </div>

</div>
