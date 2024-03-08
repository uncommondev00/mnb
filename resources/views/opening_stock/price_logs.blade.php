<div class="col-sm-12">
	<h4>Price Logs:</h4>
	<table class="table table-condensed table-bordered table-th-green text-center table-striped add_opening_stock_table">
			<thead>
			<tr>
				<th>@lang( 'Previous Price' )</th>
				<th>@lang( 'Current Price' )</th>
				<th>@lang( 'Date' )</th>
				<th>@lang( 'Changed By' )</th>

			</tr>
			</thead>

			
			<tbody>
				@foreach($price_logs as $pl)

					<tr>
						<td class="display_currency" data-currency_symbol="true">{{$pl->previous_price}}</td>
						<td class="display_currency" data-currency_symbol="true">{{$pl->current_price}}</td>
						<td>{{$pl->created_at->toDayDateTimeString()}}</td>
						<td>{{$pl->first_name}} {{$pl->last_name}}</td>
					</tr>

				@endforeach
			</tbody>
			

	</table>
	
</div>