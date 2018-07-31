
<div class="col-md-3 col-sm-6">
    <div class="card" style="width: 20rem;">
        <a href="{{ route('admin.stores.show', $store->id) }}">
          <img class="card-img-top img-responsive" src="{{ asset("storage/$store->cover") }}" alt="{{$store->name}}" height="100px"  width="200px">
        </a>
        <div class="card-body">
            <h4 class="card-title">{{strtoupper($store->name)}}</h4>
            <p class="card-text">{{$store->description}}</p>
            <a href="{{ route('admin.stores.edit', $store->id) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('admin.products.create.by-store', $store->id) }}" class="btn btn-success">Add Product</a>
        </div>
    </div>
</div>
