@extends('layouts.app')
@section('title', __( 'Stock Alert'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header no-print">
    <h1>Stock Alert
    </h1>
</section>

<!-- Main content -->
<section class="content no-print">
   @can('stock_report.view')
         <div class="col-sm-12">
          @component('components.widget', ['class' => 'box-warning'])
            @slot('icon')
              <i class="fa fa-exclamation-triangle text-yellow" aria-hidden="true"></i>
            @endslot
            @slot('title')
              {{ __('home.product_stock_alert') }} @show_tooltip(__('tooltip.product_stock_alert'))
            @endslot
            <table class="table table-bordered table-striped" id="stock_alert_table">
              <thead>
                <tr>
                  <th>@lang( 'sale.product' )</th>
                  <th>@lang( 'business.location' )</th>
                  <th>@lang( 'report.current_stock' )</th>
                  <th>Action</th>
                </tr>
              </thead>
            </table>
          @endcomponent
      </div>
      @endcan

   <div class="modal fade stock_alert_modal" tabindex="-1" role="dialog" 
      aria-labelledby="gridSystemModalLabel">
    </div>
</section>


@stop

@section('javascript')
<script>
  $(document).ready(function() {
    //stock alert datatables
    var stock_alert_table = $('#stock_alert_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/home/product-stock-alert',
        fnDrawCallback: function(oSettings) {
            __currency_convert_recursively($('#stock_alert_table'));
        },
    });
});

  $(document).on('click', '.view-other-loc-stocks', function(e) {
        e.preventDefault();

        var href = $(this).data('href');
        var container = $(this).data('container');
        $.ajax({
            url: $(this).data('href'),
            dataType: 'html',
            success: function(result) {
                $(container)
                    .html(result)
                    .modal('show');
            },
        });
    });
</script>
@endsection