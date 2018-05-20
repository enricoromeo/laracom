@if(!$stores->isEmpty())
    <table class="table">
        <thead>
        <tr>
            <td class="col-md-2">Name</td>
            <td class="col-md-2">Description</td>
            <td class="col-md-2">Cover</td>
            <td class="col-md-1">Status</td>
            <td class="col-md-2">Employees</td>
            <td class="col-md-3">Actions</td>
        </tr>
        </thead>
        <tbody>
        @foreach ($stores as $store)
            <tr>
                <td><a href="{{ route('admin.stores.show', $store->id) }}">{{ $store->name }} </a></td>
                <td>{{ $store->description }}</td>
                <td class="text-center">
                    @if(isset($store->cover))
                        <img src="{{ asset("storage/$store->cover") }}" alt="" class="img-responsive">
                    @else
                        -
                    @endif
                </td>
                <td>@include('layouts.status', ['status' => $store->status])</td>
                <td>
                    @if($store->employees)
                      @foreach ($store->employees as $employee)
                         <ul>
                           <li><a href="{{ route('admin.employees.show', $employee->id)}}">{{ $employee->name }} </a></li>
                         </ul>
                      @endforeach
                    @endif
                </td>
                <td>
                    <form action="{{ route('admin.stores.destroy', $store->id) }}" method="post" class="form-horizontal">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="delete">
                        <div class="btn-group">
                            <a href="{{ route('admin.stores.edit', $store->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                            <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Delete</button>
                        </div>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
