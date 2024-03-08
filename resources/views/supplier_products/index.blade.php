@extends('layouts.app')
@section('title', "Supplier Products")

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>{{$supplier->name}} Products
        <small>Manage Supplier Products</small>
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
        @component('components.widget', ['class' => 'box-primary', 'title' =>  " Product Lists"])
            @can('product.view')
                <div class="table-responsive">
                    <table class="table table-bordered table-striped ajax_view table-text-center" id="product_table1">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="select-all-row1"></th>
                                <th>SKU</th>
                                <th>Product</th>
                                <th>Unit</th>
                                <th>Brand</th>
                                <th>Category</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>
                                    <input type="checkbox" class="row-select1" value="{{$product->id}}">
                                </td>
                                <td>
                                    {{$product->sku}}
                                </td>
                                <td>
                                    {{$product->product}}
                                </td>
                                <td>
                                    {{$product->unit}}
                                </td>
                                <td>
                                    {{$product->brand}}
                                </td>
                                <td>
                                    {{$product->category}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6">
                                <div style="display: flex; width: 100%;">
                                    
                                    {!! Form::open(['url' => action('SupplierProductController@massAddProducts', $supplier_id), 'method' => 'post', 'id' => 'mass_add_product' ]) !!}
                                    {!! Form::hidden('selected_products1', null, ['id' => 'selected_products1']); !!}
                                    {!! Form::submit("Add Selected", array('class' => 'btn btn-xs btn-success', 'id' => 'add-selected-product')) !!}
                                    {!! Form::close() !!}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endcan
        @endcomponent
    </div>
     <div class="col-lg-6">
        @component('components.widget', ['class' => 'box-primary', 'title' =>  " Added Products"])
            @can('product.view')
                <div class="table-responsive">
                    <table class="table table-bordered table-striped ajax_view table-text-center" id="product_table2">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="select-all-row2"></th>
                                <th>SKU</th>
                                <th>Product</th>
                                <th>Unit</th>
                                <th>Brand</th>
                                <th>Category</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($added_products as $added_product)
                            <tr>
                                <td>
                                    <input type="checkbox" class="row-select2" value="{{$added_product->id}}">
                                </td>
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
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6">
                                <div style="display: flex; width: 100%;">
                                    
                                    {!! Form::open(['url' => action('SupplierProductController@massRemoveProducts', $supplier_id), 'method' => 'post', 'id' => 'mass_remove_product' ]) !!}
                                    {!! Form::hidden('selected_products2', null, ['id' => 'selected_products2']); !!}
                                    {!! Form::submit("Remove Selected", array('class' => 'btn btn-xs btn-danger', 'id' => 'remove-selected-product')) !!}
                                    {!! Form::close() !!}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
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
        $(document).on('click', '#select-all-row1', function(e) {
            if (this.checked) {
                $(this)
                    .closest('table')
                    .find('tbody')
                    .find('input.row-select1')
                    .each(function() {
                        if (!this.checked) {
                            $(this)
                                .prop('checked', true)
                                .change();
                        }
                    });
            } else {
                $(this)
                    .closest('table')
                    .find('tbody')
                    .find('input.row-select1')
                    .each(function() {
                        if (this.checked) {
                            $(this)
                                .prop('checked', false)
                                .change();
                        }
                    });
            }
        });

        $(document).on('click', '#select-all-row2', function(e) {
            if (this.checked) {
                $(this)
                    .closest('table')
                    .find('tbody')
                    .find('input.row-select2')
                    .each(function() {
                        if (!this.checked) {
                            $(this)
                                .prop('checked', true)
                                .change();
                        }
                    });
            } else {
                $(this)
                    .closest('table')
                    .find('tbody')
                    .find('input.row-select2')
                    .each(function() {
                        if (this.checked) {
                            $(this)
                                .prop('checked', false)
                                .change();
                        }
                    });
            }
        });

        $(document).on('change', '.row-select1', function() {

            if(!$(this).is(":checked")){
             $("#select-all-row1").prop('checked', false);
            }
            if($(".row-select1:checked").length == $(".row-select1").length) {
                $("#select-all-row1").prop('checked', true);
            }
            
        });

        $(document).on('change', '.row-select2', function() {

            if(!$(this).is(":checked")){
             $("#select-all-row2").prop('checked', false);
            }
            if($(".row-select2:checked").length == $(".row-select2").length) {
                $("#select-all-row2").prop('checked', true);
            }
            
        });

        $(document).ready( function(){
            var product_table1 = $('#product_table1').DataTable({
                processing: true,
                columnDefs: [ {
                    "targets": [0],
                    "orderable": false,
                    "searchable": false
                } ],
                aaSorting: [1, 'asc']
            });

            var product_table2 = $('#product_table2').DataTable({
                processing: true,
                columnDefs: [ {
                    "targets": [0],
                    "orderable": false,
                    "searchable": false
                } ],
                aaSorting: [1, 'asc']
            });

            $(document).on('click', '#add-selected-product', function(e){
                e.preventDefault();
                var selected_rows1 = [];
                var i = 0;
                $('.row-select1:checked').each(function () {
                    selected_rows1[i++] = $(this).val();
                }); 
                
                if(selected_rows1.length > 0){
                    $('input#selected_products1').val(selected_rows1);
                    swal({
                        title: LANG.sure,
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((willDelete) => {
                        if (willDelete) {
                            $('form#mass_add_product').submit();
                        }
                    });
                } else{
                    $('input#selected_products1').val('');
                    swal('@lang("lang_v1.no_row_selected")');
                }    
            });

            $(document).on('click', '#remove-selected-product', function(e){
                e.preventDefault();
                var selected_rows2 = [];
                var i = 0;
                $('.row-select2:checked').each(function () {
                    selected_rows2[i++] = $(this).val();
                }); 
                
                if(selected_rows2.length > 0){
                    $('input#selected_products2').val(selected_rows2);
                    swal({
                        title: LANG.sure,
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((willDelete) => {
                        if (willDelete) {
                            $('form#mass_remove_product').submit();
                        }
                    });
                } else{
                    $('input#selected_products2').val('');
                    swal('@lang("lang_v1.no_row_selected")');
                }    
            });

 
        });

    </script>
@endsection