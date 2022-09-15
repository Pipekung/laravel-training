@if(session()->get('success'))
<div class="alert alert-success mb-0">
    {{ session()->get('success') }}
</div>
<br />
@endif
<a href="{{ route('product.create') }}" class="btn btn-primary btn-lg mb-3">Create</a>
<!-- <div class="row">
    <div class="col-4">
        <div class="card">
            <div class="card-body text-center bg-secondary text-white h3 m-0">
                Waiting: {{ $waiting_amount }}
            </div>
        </div>
        <div class="card">
            <div class="card-body text-center bg-secondary text-white h3 m-0">
                Price: {{ $waiting_price }}
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-body text-center bg-info text-white h3 m-0">
                Processing: {{ $processing_amount }}
            </div>
        </div>
        <div class="card">
            <div class="card-body text-center bg-info text-white h3 m-0">
                Price: {{ $processing_price }}
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-body text-center bg-success text-white h3 m-0">
                In Stock: {{ $instock_amount }}
            </div>
        </div>
        <div class="card">
            <div class="card-body text-center bg-success text-white h3 m-0">
                Price: {{ $instock_price }}
            </div>
        </div>
    </div>
</div> -->
<table class="table table-striped mt-4">
    <thead>
        <tr>
            <td>ID</td>
            <td>Name</td>
            <td>Amount</td>
            <td>Price</td>
            <td>Status</td>
            <td colspan="2"></td>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $v)
        <tr>
            <td>{{$v->id}}</td>
            <td>{{$v->name}}</td>
            <td>{{$v->amount}}</td>
            <td>{{$v->price}}</td>
            <td>{{$v->status}}</td>
            <td width="50"><a href="{{ route('product.edit', $v->id)}}" class="btn btn-primary">Edit</a></td>
            <td width="50">
                <form action="{{ route('product.destroy', $v->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit" onclick="return confirm('Confirm delete data ?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
