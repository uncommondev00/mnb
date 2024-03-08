@extends('layouts.app')
@section('title', __('Requested Stock'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header no-print">
    <h1>Requested Stock
    </h1>
</section>

<!-- Main content -->
<section class="content no-print">
    @component('components.widget', ['class' => 'box-primary', 'title' => __('Requested Stock')])
     
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="stock_transfer_table">
                <thead>
                    <tr>
                        <th>@lang('messages.date')</th>
                        <th>Request From</th>
                        <th>Request To</th>
                        <th>Status</th>
                        <th>@lang('messages.action')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requested_stocks as $requested_stock)
                    @php
                        $from = App\BusinessLocation::findOrFail($requested_stock->from_id);
                        $to = App\BusinessLocation::findOrFail($requested_stock->to_id);
                    @endphp
                        <tr>
                            <td>{{ @format_date($requested_stock->request_date )}}</td>
                            <td>
                                {{$from->name}}
                            </td>
                            <td>
                                {{$to->name}}
                            </td>
                            <td>
                                {{ucfirst($requested_stock->status)}}
                            </td>
                            <td>
                                @if($requested_stock->status == "pending")
                                    <a type="button" class="btn btn-xs btn-primary" href="{{route('edit-request-stock', $requested_stock->id)}}">
                                            Approve
                                    </a>
                                @endif
                                <button data-id="{{$requested_stock->id}}" type="button" title="View" class="btn btn-primary btn-xs view_stock_transfer"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endcomponent
</section>

<section id="receipt_section" class="print_section"></section>

<!-- /.content -->
@stop
@section('javascript')
    <script src="{{ asset('js/stock_request.js?v=' . $asset_v) }}"></script>
@endsection