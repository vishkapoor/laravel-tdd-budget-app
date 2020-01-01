{{ csrf_field() }}
<div class="form-group">
	<label for="description">Description</label>
	<input type="text" name="description" 
		class="form-control @error('description') ? is-invalid @enderror" 
		value="{{ old('description') ?: $transaction->description }}">
</div>
<div class="form-group">
	<label for="amount">Amount</label>
	<input type="number" min="1" name="amount" 
		class="form-control @error('amount') ? is-invalid @enderror" 
		value="{{ old('amount') ?: $transaction->amount }}">
</div>
<div class="form-group
	{{ $errors->has('category_id') ? 'has-error' : '' }}">
	<label for="category">Category</label>
	<select name="category_id" id="category_id" 
		class="form-control">
		@foreach($categories as $category)
		<option 
			{{ $category->id == ( old('category_id') ?: $transaction->category_id ) ? 'selected' : '' }}
			value="{{$category->id}}">
			{{ $category->name}}
		</option>
		@endforeach	
	</select>
</div>
<button class="btn btn-outline-success" type="submit">
	{{ isset($buttonText) ? $buttonText: 'Save' }}
</button>
