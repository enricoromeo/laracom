@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
            @if($store)
            <!-- Default box -->
            <div class="box">
              @include('admin.shared.box-header-box-tools', ['boxTitle' => $store->name])
                <div class="box-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <td class="col-md-2">Name</td>
                            <td class="col-md-3">Description</td>
                            <td class="col-md-3">Cover</td>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $store->name }}</td>
                                <td>{{ $store->description }}</td>
                                <td>
                                    @if(isset($store->cover))
                                        <img src="{{ asset("storage/$store->cover") }}" class="img-responsive" alt="">
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.stores.index') }}" class="btn btn-default btn-sm">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.box -->
                @if($products)
                    <div class="box">
                          @include('admin.shared.box-header-box-tools', ['boxTitle' => "Products of " . $store->name])
                          <div class="box-body">
                            @include('admin.shared.products', ['products' => $products])
                          </div>

                        <div class="box-footer">
                          {{ $products->links() }}
                        </div>
                    </div>
                @endif
            @endif <!-- /. end if Store -->

    </section>
    <!-- /.content -->
@endsection
