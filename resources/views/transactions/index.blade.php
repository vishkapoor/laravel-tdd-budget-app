@extends('layouts/app')

@section('content')
<div class="container-fluid">
	<div class="card card-default">
		<div class="card-header">All Transactions</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-3">
					Category:
					<select 
						class="form-control" 
						id="categoryFilter" 
						onchange="window.location='/transactions/' + this.value">
						@foreach($categories as $category)
							<option value="{{$category->slug}}">{{$category->name}}</option>
						@endforeach
					</select>
				</div>
				<div class="col-md-3">
					Months:<br/>
					<form action="" method="GET" id="monthsForm">
						<select 
							onchange="document.getElementById('monthsForm').submit()" 
							class="form-control" name="month" id="month">
							@foreach($months as $key => $value)
								<option 
									{{ $month == $key ? 'selected' : '' }}
									value="{{$key}}">{{$value}}</option>
									}
							@endforeach
						</select>
					</form>
				</div>
			</div>
			<div class="row mt-2">
				<div class="col-ms-12">
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
	</div>
</div>
@endsection