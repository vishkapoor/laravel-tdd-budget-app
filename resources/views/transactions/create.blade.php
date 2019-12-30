@extends('layouts.app')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6 offset-3">
				<div class="card card-default">
					<div class="card-header">
						Create Transaction
					</div>
					<div class="card-body">
						@include('errors')
						<form action="/transactions" method="POST">
							{{ csrf_field() }}
							<div class="form-group">
								<label for="description">Description</label>
								<input type="text" name="description" 
									class="form-control @error('description') ? is-invalid @enderror" 
									value="{{ old('description') }}">
							</div>
							<div class="form-group">
								<label for="amount">Amount</label>
								<input type="number" min="1" name="amount" 
									class="form-control @error('amount') ? is-invalid @enderror" 
									value="{{ old('amount') }}">
							</div>
							<div class="form-group
								{{ $errors->has('category_id') ? 'has-error' : '' }}">
								<label for="category">Category</label>
								<select name="category_id" id="category_id" 
									class="form-control">
									@foreach($categories as $category)
									<option 
										{{ $category->id == old('category_id') ? 'selected' : '' }}
										value="{{$category->id}}">
										{{ $category->name}}
									</option>
									@endforeach	
								</select>
							</div>
							<button class="btn btn-outline-success" type="submit">
								Save
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection