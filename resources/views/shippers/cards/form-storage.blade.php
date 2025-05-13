<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">{{ __('Склады') }}</h3>
    </div>

    <div class="card-body">
        <div class="form-group">
            @foreach ($storages as $key => $storage)
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="customCheckbox{{$key}}" value="{{ $storage->id }}" name="storages[]" @if ($storage->isSelected($shipper->storages)) checked @endif>
                <label for="customCheckbox{{$key}}" class="custom-control-label">{{ $storage->name }}</label>
            </div>
            @endforeach
        </div>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
