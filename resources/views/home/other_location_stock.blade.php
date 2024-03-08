
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">

    <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	      <h4 class="modal-title" id="modalTitle"><b>Other Stocks</h4>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-sm-12">
          <div class="table-responsive">
            <table class="table table-condensed table-bordered table-th-green text-center table-striped" id="product_table1">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Location</th>
                  <th>Current stock</th>
                </tr>
              </thead>
              <tbody>
                @if(!empty(json_decode($stocks)))
                  @foreach($stocks as $stock)
                    <tr>
                        <td>
                            {{$stock->product}}
                        </td>
                        <td>
                            {{$stock->location}}
                        </td>
                        <td>
                            {{$stock->stock}}
                        </td>
                       
                    </tr>
                  @endforeach
                @else
                  <tr>
                        <td colspan="3">
                            No available stock in other location.
                        </td>
                        
                    </tr>
                @endif
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