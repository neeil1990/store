<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">
            {{ __('Филтры') }}
            <i class="far fa-question-circle ml-1" data-toggle="tooltip" title="{{ __('Подключить фильтр из раздела "К закупке"') }}"></i>
        </h3>
    </div>

    <div class="card-body">
        <div class="form-group">
            <label>{{ __('Выбрать фильтр') }}</label>
            <select class="form-control select2" name="filter" style="width: 100%;">
                <option value="">{{ __('Не выбрано') }}</option>

                @foreach ($filters as $filter)
                    <option value="{{ $filter->id }}" {{ $shipper->getFilterId() == $filter->id ? 'selected' : '' }}>
                        {{ $filter->name }} ({{ $filter->user->name }})
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
