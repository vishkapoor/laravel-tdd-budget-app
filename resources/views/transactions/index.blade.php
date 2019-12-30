@extends('layouts/app')

<div class="container">
	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th>Date</th>
					<th>Description</th>
					<th>Category</th>
				</tr>
			</thead>
			<tbody>
				@foreach($transactions as $transaction)
					<tr>
						<td>{{ $transaction->created_at->diffForHumans() }}</td>
						<td> {{ $transaction->description }}</td>
						<td> {{ $transaction->category->name }} </td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>