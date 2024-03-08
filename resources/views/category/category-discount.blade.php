@extends('layouts.app')
@section('title', 'Categories')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang( 'category.categories' )
        <small>@lang( ' Manage categories discount' )</small>
    </h1>

</section>

<!-- Main content -->
<section class="content">
    @component('components.widget', ['class' => 'box-primary', 'title' => __( 'category.manage_your_categories' )])

        @can('category.view')
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="category_discount">
                    <thead>
                        <tr>
                            <th>@lang( 'category.category' )</th>
                            <th>@lang( 'Discount' )</th>
                            <th>@lang( 'Status' )</th>
                            <th>@lang( 'messages.action' )</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>{{$category->name}}</td>
                            <td>{{$category->cat_discount}}</td>
                            <td>
                                @if($category->cat_status == 0)
                                <span class="label bg-red">Off</span>
                                @else
                                <span class="label bg-green">On</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-xs btn-primary category-discount" data-href="{{route('editcategoryDiscount', $category->id)}}" data-container=".category_modal">
                                    <i class="fa fa-edit"></i> Manage Discount
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endcan
    @endcomponent

    <div class="modal fade category_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>

</section>
<!-- /.content -->

@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready( function(){
        $('#category_discount').DataTable({

        });

        $(document).on('click', '.category-discount', function(e) {
        e.preventDefault();
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

    });
</script>
@endsection