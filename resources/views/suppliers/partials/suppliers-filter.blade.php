<h5>{{ __('Фильтр') }}</h5>

<div class="form-group">
    <label>{{ __('Склад') }}</label>
    @foreach($store as $index => $s)
    <div class="custom-control custom-checkbox">
        <input class="custom-control-input store-filter" name="stores[]" type="checkbox" id="customCheckbox-{{ $index }}" value="{{ $s->uuid }}" onclick="$.suppliers.$table.draw()">
        <label for="customCheckbox-{{ $index }}" class="custom-control-label">{{ $s->name }}</label>
    </div>
    @endforeach
</div>

