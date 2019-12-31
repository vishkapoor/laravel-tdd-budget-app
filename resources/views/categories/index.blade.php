@extends('layouts/app')

@section('content')
<div class="container-fluid">
	<div class="card card-default">
		<div class="card-header">All Categories</div>
		<div class="card-body">
			<table class="table">
				<thead>
					<tr>
						<th>Id</th>
						<th>Name</th>
						<th>Slug</th>
						<th>Created Date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($categories as $category)
						<tr>
							<td> {{ $category->id }} </td>
							<td> 
								<a href="{{ route('categories.edit', $category->slug) }}">
									{{ $category->name }}
								</a> 
							</td>
							<td> {{ $category->slug }} </td>
							<td>{{ $category->created_at->format('d/m/Y') }}</td>
							<td>
								<form 
									method="POST"
									action="/categories/{{$category->slug}}">
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
			{{ $categories->links() }}
		</div>
	</div>
</div>
@endsection