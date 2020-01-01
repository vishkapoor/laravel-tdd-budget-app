{{ csrf_field() }}
<div class="form-group">
	<label for="name">Name</label>
	<input type="text" name="name" 
		class="form-control @error('name') ? is-invalid @enderror" 
		value="{{ old('name') ?: $category->name }}">
</div>
<button class="btn btn-outline-success" type="submit">
	{{ isset($buttonText) ? $buttonText: 'Save' }}
</button>
