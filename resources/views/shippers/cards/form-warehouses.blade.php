@method('PATCH')

<div class="form-group">
    <label>{{ __('Склады') }}</label>

    @foreach (\App\Models\Store::all() as $key => $storage)
        <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" id="customCheckbox{{$key}}" value="{{ $storage->id }}" name="warehouses[]">
            <label for="customCheckbox{{$key}}" class="custom-control-label">{{ $storage->name }}</label>
        </div>
    @endforeach
</div>
