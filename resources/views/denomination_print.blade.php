<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>

<style type="text/css">
	.pos-container{
		  font-size: 12px;
		

		  width: 50mm;
		  background: #FFF;
		  font-family: MS Gothic !important; 
	}

	.head{
		margin-left: -2px;
		margin-right: : 2px;
	}

	.content{
		margin-left: -2px;
		margin-right: : 2px;
		text-align: left;
	}

	.foot{
		margin-left: -2px;
		margin-right: : 2px;
	}
	.content table tr{
		margin-top: 10px;
	}

</style>

<body>
	
	<div class="pos-container">
		
		<div class="head">
			<h4> Date: {{ \Carbon::now()->format('jS M, Y h:i A') }}</h4>
		</div>

		<hr style="border: 1px dashed; margin-right: 5px;">

		<div class="content">
			<table>
				<tr>
					<td> 1000 </td>
					<td> x </td>
					<td> {{$data['denom1000']}} </td>
					<td> = </td>
					<td> Php {{number_format($data['denom1000'] * 1000, 2)}}</td>
				</tr>
				<tr>
					<th>500</th>
					<td>x</td>
					<th>{{$data['denom500']}}</th>
					<td>=</td>
					<th>Php {{number_format($data['denom500'] * 500, 2)}}</th>
				</tr>
				<tr>
					<th>200</th>
					<td>x</td>
					<th>{{$data['denom200']}}</th>
					<td>=</td>
					<th>Php {{number_format($data['denom200'] * 200, 2)}}</th>
				</tr>
				<tr>
					<th>100</th>
					<td>x</td>
					<th>{{$data['denom100']}}</th>
					<td>=</td>
					<th>Php {{number_format($data['denom100'] * 100, 2)}}</th>
				</tr>
				<tr>
					<th>50</th>
					<td>x</td>
					<th>{{$data['denom50']}}</th>
					<td>=</td>
					<th>Php {{number_format($data['denom50'] * 50, 2)}}</th>
				</tr>
				<tr>
					<th>20</th>
					<td>x</td>
					<th>{{$data['denom20']}}</th>
					<td>=</td>
					<th>Php {{number_format($data['denom20'] * 20, 2)}}</th>
				</tr>
				<tr>
					<th>10</th>
					<td>x</td>
					<th>{{$data['denom10']}}</th>
					<td>=</td>
					<th>Php {{number_format($data['denom10'] * 10, 2)}}</th>
				</tr>
				<tr>
					<th>5</th>
					<td>x</td>
					<th>{{$data['denom5']}}</th>
					<td>=</td>
					<th>Php {{number_format($data['denom5'] * 5, 2)}}</th>
				</tr>
				<tr>
					<th>1</th>
					<td>x</td>
					<th>{{$data['denom1']}}</th>
					<td>=</td>
					<th>Php {{number_format($data['denom1'] * 1, 2)}}</th>
				</tr>
				<tr>
					<th>25¢</th>
					<td>x</td>
					<th>{{$data['denom_25']}}</th>
					<td>=</td>
					<th>Php {{number_format($data['denom_25'] * .25, 2)}}</th>
				</tr>
			</table>
		</div>

		<hr style="border: 1px dashed; margin-right: 5px;">

		<div class="foot">
	        <div class="col-sm-12">

		        <h4>Total: Php {{number_format($data['total'], 2)}}</h4>
		        <h4>Cashier: {{ $register_details->user_name}} </h4>
		        <h4>Checked by: _______________ </h4>

	        </div>
      </div>
	</div>	

</body>

</html>