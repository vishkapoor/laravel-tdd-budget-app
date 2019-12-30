@extends('layouts/app')

@section('content')
<div class="container-fluid">
	<div class="card card-default">
		<div class="card-header">All Transactions</div>
		<div class="card-body">
			<table class="table">
				<thead>
					<tr>
						<th>Id</th>
						<th>Description</th>
						<th>Category</th>
						<th>Amount</th>
						<th>Date</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>
					@foreach($transactions as $transaction)
						<tr>
							<td> {{ $transaction->id }} </td>
							<td> 
								<a href="{{ route('transactions.edit', $transaction->id) }}">
									{{ $transaction->description }}
								</a> 
							</td>
							<td> {{ $transaction->category->name }} </td>
							<td> {{ $transaction->amount }}</td>
							<td>{{ $transaction->created_at->format('d/m/Y') }}</td>
							<td>
								<form 
									method="POST"
									action="/transactions/{{$transaction->id}}">
									{{ method_field('DELETE') }}
									{{ csrf_field() }}
									<button 
										type="submit"
										class="btn btn-danger btn-xs">
										Delete
									</button>
								</form>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			{{ $transactions->links() }}
		</div>
	</div>
</div>
@endsection