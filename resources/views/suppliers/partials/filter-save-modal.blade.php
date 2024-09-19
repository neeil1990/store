<x-modal id="filter-save-modal" title="Сохранить настройки фильтра" action="{{ route('filters.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label>{{ __('Название') }}</label>
        <input type="text" name="name" class="form-control" placeholder="{{ __('Название') }}">
    </div>

    <div class="form-group">
        <label>{{ __('Обновить существующий') }}</label>
        <select class="custom-select" name="id">
            <option value="0">{{ __('Не обновлять') }}</option>
            @foreach ($filters as $filter)
                <option value="{{ $filter['id'] }}" @if($filter['active']) selected="" @endif>{{ $filter['name'] }}</option>
            @endforeach
        </select>
    </div>

    <input type="hidden" name="params" required>

    <x-slot:footer>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Закрыть') }}</button>
        <button type="submit" class="btn btn-primary">{{ __('Сохранить') }}</button>
    </x-slot:footer>
</x-modal>
