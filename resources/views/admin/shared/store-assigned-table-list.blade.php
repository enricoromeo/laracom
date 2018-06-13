<div class="form-group">
  <div class="table-responsive">
      <label for="tableStoreAssigned">Store Assigned:</label>
    <table class="table">
      <thead>
        <tr>
          <th>Cover</th>
          <th>Name</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>

          @foreach($employeeStores as $store)
            <tr>
              <td>
                @if(isset($store->cover))
                    <img src="{{ asset("storage/$store->cover") }}" alt="" class="img-thumbnail" height="100" width="200">
                @else
                    -
                @endif
              </td>
              <td>{{ $store->name }}</td>
              <td>@include('layouts.status', ['status' => $store->status])</td>
              <td>
                    <div class="btn-group">
                        <a href="{{ route('admin.stores.edit', $store->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                        <a href="{{ route('admin.employee.profile.detachstore', [$employee->id, $store->id]) }}" class="btn btn-warning btn-sm"
                          onclick="return confirm('Confermare la disconessione della Release dall\'Artista?)">
                          <i class="fa fa-chain-broken"></i> Scollega</a>
                    </div
              </td>

            </tr>
            @endforeach

      </tbody>
    </table>
  </div>
</div>
