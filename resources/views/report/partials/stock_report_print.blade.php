<!DOCTYPE html>
<html>
<head>
<style>
#reports {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#reports td, #reports th {
  border: 1px solid #ddd;
  padding: 8px;
}

#reports tr:nth-child(even){background-color: #f2f2f2;}

#reports tr:hover {background-color: #ddd;}

#reports th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
</style>
</head>
<body>
	@php
		//location name
		$loc_name = json_decode($location, true);
        $l_name = $loc_name[0]['name'];
		//total stocks footer
	    $stock = json_decode($t_stock, true);
        $stck = $stock[0]['total_stock'];
        //date now
        $date = \Carbon\Carbon::now()->toDayDateTimeString();
	@endphp

<h3>Stock Report | {{$l_name}} ({{$date}})</h3>
<table id="reports">
	<thead>
		<tr>
		   <th>SKU</th>
		   <th>Product</th>
		   <th>Purchase Price</th>
		   <th>Unit Price</th>
		   <th>Stock</th>
		</tr>
	</thead>
	<tbody>
		@foreach($products as $product)
		<tr>
			<td>{{$product->sku}}</td>
			<td>{{$product->product}}</td>
			<td>{{$product->purchase_price}}</td>
			<td>{{$product->price}}</td>
			<td>{{number_format($product->total_stock,0)}}</td>
		</tr>
		@endforeach
	</tbody>
	<tfoot>
		<tr>
			<th colspan="4" style="text-align: right;">Total:</th>
			<th>{{number_format($stck,0)}}</th>
		</tr>
	</tfoot>
		
  
</table>

</body>
</html>
