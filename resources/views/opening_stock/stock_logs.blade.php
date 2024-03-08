<div class="col-sm-12">
	<h4>Stock Logs:</h4>
	<table class="table table-condensed table-bordered table-th-green text-center table-striped add_opening_stock_table">
			<thead>
			<tr>
				<th>@lang( 'Previous Stock' )</th>
				<th>@lang( 'Current Stock' )</th>
				<th>@lang( 'Date' )</th>
				<th>@lang( 'Changed By' )</th>

			</tr>
			</thead>

			
			<tbody>
				@foreach($stock_logs as $sl)

					<tr>
						<td>{{$sl->previous_stock}}</td>
						<td>{{$sl->current_stock}}</td>
						<td>{{$sl->created_at->toDayDateTimeString()}}</td>
						<td>{{$sl->first_name}} {{$sl->last_name}}</td>
					</tr>

				@endforeach
			</tbody>
			

	</table>
	
</div>