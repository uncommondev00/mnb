@extends('layouts.app')
@section('title', "Customer Discount")

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> {{$product->name}}
        <small>Customer Discount</small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">

<div class="row col-12">
    <div class="col-lg-6">
        @component('components.widget', ['class' => 'box-primary', 'title' =>  " Customers"])
            @can('product.view')
                {!! Form::open(['url' => route('store-customer-discount', $product->id), 'method' => 'post' ]) !!}
                <div class="box box-solid">
                    <div class="box-body">
                        <div class="row">
                             <div class="col-6">
                              <div class="form-group">
                                {!! Form::label('customer_id', __('Customer') . ':*') !!}
                                
                                  {!! Form::select('customer_id', $customers, null, ['class' => 'form-control', 'id'=>'customer_id', 'placeholder' => __( 'Select Customer' ), 'required']); !!}
                                  
                                  
                              </div>
                            </div>
                              <div class="col-6">
                                 <div class="form-group">
                                {!! Form::label('discount', __( 'Discount (%)' ) . ':*') !!}
                                  {!! Form::text('discount', null, ['class' => 'input_number form-control', 'required', 'id'=>'discount', 'placeholder' => __( 'Customer Product Discount' ) ]); !!}
                              </div>
                            </div>

                           
                            
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary pull-right">@lang('messages.save')</button>
                            </div>
                        </div>
                    </div>
                </div> <!--box end-->
                {!! Form::close() !!}
            @endcan
        @endcomponent
    </div>
     <div class="col-lg-6">
        @component('components.widget', ['class' => 'box-primary', 'title' =>  " Added Customer Discount"])
            @can('product.view')
                <div class="table-responsive">
                    <table class="table table-bordered table-striped ajax_view table-text-center" id="product_table2">
                        <thead>
                            <tr>
                                <th>Customer Name</th>
                                <th>Discount(%)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customer_discounts as $customer_discount)
                                <tr>
                                    <td>{{$customer_discount->name}}</td>
                                    <td>{{$customer_discount->discount}} (%)</td>
                                    <td>
                                        <button type="button" class="btn btn-xs btn-danger remove-discount" data-href="{{route('remove-customer-discount', $customer_discount->id)}}">
                                            Remove
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endcan
        @endcomponent
    </div>
</div>


</section>
<!-- /.content -->

@endsection

@section('javascript')
  <script type="text/javascript">
      $(document).on('click', 'button.remove-discount', function() {
        swal({
            title: LANG.sure,
            text: "Customer discount will be removed.",
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then(willDelete => {
            if (willDelete) {
                var href = $(this).data('href');

                $.ajax({
                    method: 'DELETE',
                    url: href,
                    success: function(result) {
                        window.location.replace(result);
                    },
                });
            }
        });
    });
  </script>
@endsection