@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.stores.update', $store->id) }}" method="post" class="form" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="row">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="put">
                        <div class="col-md-8">
                            <h2>{{ ucfirst($store->name) }}</h2>
                            <div class="form-group">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="{!! $store->name ?: old('name')  !!}">
                            </div>
                            <div class="form-group">
                                <label for="description">Description </label>
                                <textarea class="form-control" name="description" id="description" rows="5" placeholder="Description">{!! $store->description ?: old('description')  !!}</textarea>
                            </div>
                            <div class="form-group">
                                @if(isset($store->cover))
                                    <div class="col-md-3">
                                        <div class="row">
                                            <img src="{{ asset("storage/$store->cover") }}" alt="" class="img-responsive"> <br />
                                            <a onclick="return confirm('Are you sure?')" href="{{ route('admin.store.remove.image', ['store' => $store->id, 'image' => substr($store->cover, 9)]) }}" class="btn btn-danger btn-sm btn-block">Remove image?</a><br />
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="row"></div>
                            <div class="form-group">
                                <label for="cover">Cover </label>
                                <input type="file" name="cover" id="cover" class="form-control">
                            </div>

                            <div class="row"></div>

                            <div class="form-group">
                                <label for="status">Status </label>
                                <select name="status" id="status" class="form-control">
                                    <option value="0" @if($store->status == 0) selected="selected" @endif>Disable</option>
                                    <option value="1" @if($store->status == 1) selected="selected" @endif>Enable</option>
                                </select>
                            </div>

                            <div class="row"></div>

                           <div class="form-group">
                             <label for="products"> Products </label>
                             <table class="table table-sm">
                               <thead>
                                 <tr>
                                   <th scope="col">#</th>
                                   <th scope="col">Cover</th>
                                   <th scope="col">Name</th>
                                   <th scope="col">Description</th>
                                   <th scope="col">Quantity</th>
                                   <th scope="col">Status</th>
                                 </tr>
                               </thead>
                               <tbody>
                                 @if($store->products)
                                   @foreach($store->products as $product)
                                     <tr>
                                       <th scope="row">{{$loop->iteration}}</th>
                                       <td><img src="{{ asset("storage/$product->cover") }}" alt="{{$product->name}}" class="img-thumbnail" height="50" width="100"></td>
                                       <td>{{$product->name}}</td>
                                       <td>{{$product->description}}</td>
                                       <td>{{$product->quantity}}</td>
                                       @if($product->status == 1)
                                         <td>Enabled</td>
                                       @else
                                         <td>Disabled</td>
                                       @endif
                                     </tr>
                                   @endforeach
                                @endif
                               </tbody>
                             </table>
                           </div>

                        </div>

                        <div class="col-md-4">
                          sidebar here

                        </div>

                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.stores.index') }}" class="btn btn-default">Back</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
