@extends('layouts/app')

@section('content')
<div class="container-fluid">
	<div class="card card-default">
		<div class="card-header">Monthly Budget</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-3">
					Category:
					<select 
						class="form-control" 
						id="categoryFilter" 
						onchange="window.location='?category=' + this.value">
						<option value='' selected>Please select</option>

						@foreach($categories as $row)
							<option 
								{{ $category->id == $row->id ? 'selected' : '' }}
								value="{{$row->slug}}">{{$row->name}}</option>
						@endforeach
					</select>
				</div>
				<div class="col-md-3">
					Months:<br/>
					<form action="/budgets" method="GET" id="monthsForm">
						<select 
							onchange="document.getElementById('monthsForm').submit()" 
							class="form-control" name="month" id="month">
							<option value='' selected>Please select</option>
							@foreach($months as $key => $value)
								<option 
									{{ $month == $key ? 'selected' : '' }}
									value="{{$key}}">{{$value}}</option>
							@endforeach
						</select>
					</form>
				</div>
			</div>
			<div class="row mt-2">
				<div class="col-md-12">
					<table class="table">
						<thead>
							<tr>
								<th>Id</th>
								<th>Category</th>
								<th>Amount</th>
								<th>Balance</th>
								<th>Budget Month</th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>
							@foreach($budgets as $budget)
								<tr>
									<td> {{ $budget->id }} </td>
									<td> 
										<a href="{{ route('budgets.edit', $budget->id) }}">
											{{ $budget->category->name }}
										</a> 
									</td>
									<td> {{ $budget->amount }}</td>
									<td> {{ $budget->balance() }} </td>
									<td>{{ $months[$budget->month] }}</td>
									<td>
										<form 
											method="POST"
											action="/budgets/{{$budget->id}}">
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
				</div>
			</div>
		</div>
	</div>
</div>
@endsection