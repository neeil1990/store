<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Параметр складской позиции') }}</h3>
    </div>
    <form method="post" action="{{ route('setting.store') }}" class="mt-6 space-y-6">
        @csrf
        <div class="card-body">
            @if(session('status') === 'setting-warehouse-item-param')
                <div class="callout callout-success alert-dismissible">
                    <p>{{ __('Параметр успешно сохранён.') }}</p>
                </div>
            @endif
            <x-text-input-icon name="key" type="hidden" value="warehouse_item_param" />
            <div class="form-group">
                <x-input-label for="warehouse_item_param" :value="__('Второй параметр складской позиции')" />
                <x-text-input-icon id="warehouse_item_param" name="value" type="text" value="{{ $warehouseItemParam ?? 'Складская позиция' }}" class="mt-1 block w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('value')" />
            </div>
        </div>
        <div class="card-footer">
            <x-primary-button>{{ __('Сохранить') }}</x-primary-button>
        </div>
    </form>
</div>
