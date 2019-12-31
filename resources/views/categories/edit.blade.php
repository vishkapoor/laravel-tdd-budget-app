@extends('layouts.app')
@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6 offset-3">
				<div class="card card-default">
					<div class="card-header">
						Update Category
					</div>
					<div class="card-body">
						@include('errors')
						<form action="/categories/{{ $category->slug }}" method="POST">
							{{ method_field('PUT') }}
							@include('categories.form', [
								'buttonText' => 'Update'
							])
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection