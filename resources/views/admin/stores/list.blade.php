@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if($stores)
            <div class="box">
                <div class="box-body">
                    <h2>Stores</h2>
                    @include('layouts.search', ['route' => route('admin.stores.index')])
                    @include('admin.shared.stores')
                    {{ $stores->links() }}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection
