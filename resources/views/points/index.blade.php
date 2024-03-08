@extends('layouts.app')
@section('title', __('Add Points'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Add Points</h1>
</section>

<!-- Main content -->
<section class="content">

	<form action="{{action('BusinessController@update_points')}}" method="post">
		{{csrf_field()}}
	    <div class="col-md-6">
              <div class="box box-warning">
                <!-- /.box-body -->
                <div class="box-body">
					<div class="form-group">
			        {!! Form::label('points_amount', __( 'Amount' ) . ':*') !!}
			          {!! Form::text('points_amount', $points->points_amount, ['class' => 'form-control number', 'required' ]); !!}
			      	</div>
			      	<div class="form-group">
			        {!! Form::label('points', __( 'A percentage of the purchase amount to be credited to the points account of the customer' ) . ':*') !!}
			          {!! Form::text('points', $points->points, ['class' => 'form-control number', 'required' ]); !!}
			      	</div>
                </div>
                <div class="box-footer">
			      <button type="submit" class="btn btn-primary pull-right">@lang( 'messages.update' )</button>
			    </div>
                <!-- /.box-body -->

              </div>
            </div>

	</form>


</section>
@endsection
