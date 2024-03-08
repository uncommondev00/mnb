<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('CategoryController@savecategoryDiscount'), 'method' => 'POST' ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">Set discount for {{$category->name}}</h4>
    </div>
    <input type="hidden" name="cat_id" value="{{$category->id}}">

    <div class="modal-body">
     <div class="form-group">
        {!! Form::label('cat_discount', __( 'Category Discount' ) . ':*') !!}
          {!! Form::text('cat_discount', $category->cat_discount, ['class' => 'form-control number', 'required', 'placeholder' => __( 'category.category_name' )]); !!}
      </div>

      <div class="form-group">
            <div class="checkbox">
              <label>
                 {!! Form::checkbox('cat_status', 1, $is_active,[ 'class' => 'toggler', 'data-toggle_id' => 'parent_cat_div' ]); !!} Activate Discount
              </label>
            </div>
        </div>
        
    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang( 'messages.update' )</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->