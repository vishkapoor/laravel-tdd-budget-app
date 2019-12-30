@extends('layouts.app')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6 offset-3">
				<div class="card card-default">
					<div class="card-header">
						Update Transaction
					</div>
					<div class="card-body">
						@include('errors')
						<form action="/transactions/{{ $transaction->id }}" method="POST">
							{{ method_field('PUT') }}
							@include('transactions.form', [
								'buttonText' => 'Update',
								'transaction' => $transaction
							])
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection