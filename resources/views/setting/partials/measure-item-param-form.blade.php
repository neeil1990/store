<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Атрибут при котором мы добавляем количество компонента в расчет продаж') }}</h3>
    </div>
    <form method="post" action="{{ route('setting.store') }}" class="mt-6 space-y-6">
        @csrf
        <div class="card-body">
            @if(session('status') === 'setting-measure-item-param')
            <div class="callout callout-success alert-dismissible">
                <p>{{ __('Параметр успешно сохранён.') }}</p>
            </div>
            @endif

            <x-text-input-icon name="key" type="hidden" value="measure_item_param" />
            <div class="form-group">
                <x-input-label for="measure_item_param" :value="__('Название атрибута')" />
                <x-text-input-icon id="measure_item_param" name="value" type="text" value="{{ $measureItemParam ?? 'Значение кол-ва в упаковке для товаров которые принимают поштучно' }}" class="mt-1 block w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('value')" />
            </div>
        </div>
        <div class="card-footer">
            <x-primary-button>{{ __('Сохранить') }}</x-primary-button>
        </div>
    </form>
</div>
