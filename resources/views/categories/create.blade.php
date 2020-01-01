@extends('layouts.app')
@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6 offset-3">
				<div class="card card-default">
					<div class="card-header">
						Create Category
					</div>
					<div class="card-body">
						@include('errors')
						<form action="/categories" method="POST">
							@include('categories.form')
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection