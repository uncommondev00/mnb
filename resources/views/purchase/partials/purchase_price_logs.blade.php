@section('css')
{!! Charts::styles() !!}
@endsection
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">

    <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	      <h4 class="modal-title" id="modalTitle"><b>({{$name}})</b> Purchase Price Logs</h4>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-md-12">
          {!! $chart->html() !!}
        </div>
        <div class="col-sm-12">
          <div class="table-responsive">
            <table class="table table-condensed table-bordered table-th-green text-center table-striped">
              <thead>
                <tr>
                  <th>Purchase Price</th>
                  <th>Selling Price</th>
                  <th>Created By</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                  @foreach($price_logs as $pl)
                    <tr>
                      <td>{{$pl->current_price}}</td>
                      <td>{{$pl->selling_price}}</td>
                      <td>{{$pl->first_name}} {{$pl->last_name}}</td>
                      <td>{{$pl->created_at->toDayDateTimeString()}}</td>
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

        {!! Charts::scripts() !!}

        {!! $chart->script() !!}
