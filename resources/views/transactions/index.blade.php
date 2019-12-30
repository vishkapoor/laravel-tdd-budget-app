@extends('layouts/app')

@section('content')
<div class="container-fluid">
	<div class="card card-default">
		<div class="card-header">All Transactions</div>
		<div class="card-body">
			<table class="table">
				<thead>
					<tr>
						<th>Description</th>
						<th>Category</th>
						<th>Amount</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody>
					@foreach($transactions as $transaction)
						<tr>
							<td> 
								<a href="{{ route('transactions.edit', $transaction->id) }}">
									{{ $transaction->description }}
								</a> 
							</td>
							<td> {{ $transaction->category->name }} </td>
							<td> {{ $transaction->amount }}</td>
							<td>{{ $transaction->created_at->diffForHumans() }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection