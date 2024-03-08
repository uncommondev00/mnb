
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">

    <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	      <h4 class="modal-title" id="modalTitle"><b>({{$supplier->name}})</b> Product Lists</h4>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-sm-12">
          <div class="table-responsive">
            <table class="table table-condensed table-bordered table-th-green text-center table-striped" id="product_table1">
              <thead>
                <tr>
                  <th>SKU</th>
                  <th>Product</th>
                  <th>Unit</th>
                  <th>Brand</th>
                  <th>Category</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                  @foreach($added_products as $added_product)
                    <tr>
                        <td>
                            {{$added_product->sku}}
                        </td>
                        <td>
                            {{$added_product->product}}
                        </td>
                        <td>
                            {{$added_product->unit}}
                        </td>
                        <td>
                            {{$added_product->brand}}
                        </td>
                        <td>
                            {{$added_product->category}}
                        </td>
                        <td>
                            <button class="btn btn-primary btn-add-selected" data-product_id="{{$added_product->product_id}}" data-variation_id="{{$added_product->variation_id}}">Add</button>
                        </td>
                    </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->