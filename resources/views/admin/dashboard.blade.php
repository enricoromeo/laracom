@extends('layouts.admin.app')

@section('content')

<style>
    .card {
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.4);
        transition: 0.3s;
        margin:6%;
    }

    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.8);
    }

    .card-body {
        padding:8px;
    }
</style>
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            @include('admin.shared.box-header-box-tools', ['boxTitle' => "My Stores"])
            <div class="box-body">

              @if (isset($employeeStores) && count($employeeStores) > 0)
                  @foreach ( $employeeStores as $store )
                          @include('admin.shared.stores-cards', ['store' => $store])
                  @endforeach
              @else
                  <h4>No Assigned Store Yet</h4>
              @endif

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              {{ $employeeStores->links() }}
            </div>
            <!-- /.box-footer-->
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
