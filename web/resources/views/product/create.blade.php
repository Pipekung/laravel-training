@if ($errors->any())
<div class="alert alert-danger">
    <ul style="margin: 0;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
<br />
@endif
<form method="post" action="{{ route('product.store') }}">
    @csrf
    <div class="form-group mb-3">
        <label for="name">Name:</label>
        <input type="text" class="form-control" name="name" value="{{ old('name') }}"/>
    </div>
    <div class="form-group mb-3">
        <label for="amount">Amount:</label>
        <input type="text" class="form-control" name="amount" value="{{ old('amount') }}"/>
    </div>
    <div class="form-group mb-3">
        <label for="price">Price:</label>
        <input type="text" class="form-control" name="price" value="{{ old('price') }}"/>
    </div>
    <div class="form-group mb-3">
        <label for="status">Status:</label>
        <select class="form-control" name="status">
            <option value="Waiting">Waiting</option>
            <option value="Processing">Processing</option>
            <option value="In Stock">In Stock</option>
        </select>
    </div>
    <button type="submit" class="btn btn-lg btn-primary">Submit</button>
    <a href="/product" class="btn btn-lg btn-secondary ms-2">Back</a>
</form>
