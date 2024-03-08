@extends('layouts.app')
@section('title', __( 'Z Reading'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header no-print">
    <h1>@lang( 'Z Reading')
        <small></small>
    </h1>
</section>

<!-- Main content -->
<section class="content no-print">
       @component('components.widget', ['class' => 'box-primary', 'title' => __( 'Z Reading')])
        
            <div class="table-responsive">
                <table class="table table-bordered table-striped ajax_view" id="product_table">
                    <thead>
                        <tr>
                            <th>@lang('Start Date')</th>
                            <th>@lang('End Date')</th>
                            <th>@lang('Starting Invoice')</th>
                            <th>@lang('Ending Invoice')</th>
                            <th>@lang('Total Invoice')</th>
                            <th>@lang('Success Transactions')</th>
                            <th>@lang('Void Transactions')</th>
                            <th>@lang('Sales Amount')</th>
                            <th>@lang('Vatable')</th>
                            <th>@lang('Vat Exempt')</th>
                            <th>@lang('Zero Rated')</th>
                            <th>@lang('Total Vat')</th>
                            <th>@lang('Prevoius Reading')</th>
                            <th>@lang('Current Sales')</th>
                            <th>@lang('Running Total')</th>
                            <th>@lang('Mac Address')</th>
                            <th>@lang('Mac Name')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr class="bg-gray font-17 footer-total text-center">
                            
                        </tr>
                    </tfoot>
                </table>
            </div>
        
    @endcomponent

</section>
<!-- /.content -->

<!-- This will be printed -->
<!-- <section class="invoice print_section" id="receipt_section">
</section> -->

@stop

@section('javascript')
<script type="text/javascript">
    $(document).ready( function(){
        var product_table = $('#product_table').DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "/reports/z-reading",
                },
                columnDefs: [ {
                    "targets": [17],
                    "orderable": false,
                    "searchable": false
                } ],
                aaSorting: [1, 'desc'],
                columns: [
                        { data: 'start_date', name: 'start_date'  },
                        { data: 'end_date', name: 'end_date'  },
                        { data: 'starting_invoice', name: 'starting_invoice'  },
                        { data: 'ending_invoice', name: 'ending_invoice'  },
                        { data: 'total_invoices', name: 'total_invoices'  },
                        { data: 'success_transactions', name: 'success_transactions'  },
                        { data: 'void_transactions', name: 'void_transactions'  },
                        { data: 'sales_amout', name: 'sales_amout'  },
                        { data: 'vatable_amount', name: 'vatable_amount'  },
                        { data: 'vat_exempt', name: 'vat_exempt'  },
                        { data: 'zero_rated', name: 'zero_rated'  },
                        { data: 'total_vat', name: 'total_vat'  },
                        { data: 'previous_reading', name: 'previous_reading'  },
                        { data: 'current_sales', name: 'current_sales'  },
                        { data: 'running_total', name: 'running_total'  },
                        { data: 'mac_address', name: 'mac_address'  },
                        { data: 'mac_name', name: 'mac_name', 'searchable': false },
                        { data: 'action', name: 'action'}
                    ]
            });
    });

</script>
<script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>
@endsection