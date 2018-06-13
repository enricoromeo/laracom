<div class="form-group">
    <label for="stores">Stores to Assign</label>
    <select class="form-control form-control-sm" name="storesWithoutEmployee[]" id="stores" multiple>
      @foreach($storesWithoutEmployee as $store)
          <option id="store{{ $store->id }}" value="{{ $store->id }}">{{$store->name}}</option>
      @endforeach
    </select>
</div>
