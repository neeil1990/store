<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Основные настройки сайта') }}</h3>
    </div>
    <form method="post" action="{{ route('setting.storeAll') }}" class="mt-6 space-y-6">
        @csrf
        <div class="card-body">
            @if(session('status') === 'setting-store-all')
                <div class="callout callout-success alert-dismissible">
                    <p>{{ __('Настройки успешно сохранены.') }}</p>
                </div>
            @endif
            <div class="form-group">
                <x-input-label for="site_title" :value="__('Заголовок сайта (Title)')" />
                <x-text-input-icon id="site_title" name="site_title" type="text" value="{{ $siteTitle ?? config('app.name') }}" class="mt-1 block w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('site_title')" />
            </div>
            <div class="form-group">
                <x-input-label for="site_name" :value="__('Название сайта')" />
                <x-text-input-icon id="site_name" name="site_name" type="text" value="{{ $siteName ?? '' }}" class="mt-1 block w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('site_name')" />
            </div>
            <div class="form-group">
                <x-input-label for="token" :value="__('Мой Склад API токен')" />
                <x-text-input-icon id="token" name="token" type="text" value="{{ $token ?? '' }}" class="mt-1 block w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('token')" />
            </div>
            <div class="form-group">
                <x-input-label for="warehouse_item_param" :value="__('Параметр складской позиции')" />
                <x-text-input-icon id="warehouse_item_param" name="warehouse_item_param" type="text" value="{{ $warehouseItemParam ?? '' }}" class="mt-1 block w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('warehouse_item_param')" />
            </div>
            <div class="form-group">
                <x-input-label for="measure_item_param" :value="__('Атрибут для расчёта продаж (кол-во в упаковке)')" />
                <x-text-input-icon id="measure_item_param" name="measure_item_param" type="text" value="{{ $measureItemParam ?? 'Значение кол-ва в упаковке для товаров которые принимают поштучно' }}" class="mt-1 block w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('measure_item_param')" />
            </div>

            <x-input-label for="show_footer_phone" :value="__('Телефон')" />
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input type="checkbox" id="show_footer_phone" name="show_footer_phone" value="1" {{ !isset($showFooterPhone) || $showFooterPhone ? 'checked' : '' }}>
                    </div>
                </div>
                <x-text-input-icon id="footer_phone" name="footer_phone" type="text" value="{{ $footerPhone ?? '+79601340303' }}" class="form-control" required />
                <x-input-error class="mt-2" :messages="$errors->get('footer_phone')" />
            </div>

            <x-input-label for="show_footer_telegram" :value="__('Телеграм')" />
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input type="checkbox" id="show_footer_telegram" name="show_footer_telegram" value="1" {{ !isset($showFooterTelegram) || $showFooterTelegram ? 'checked' : '' }}>
                    </div>
                </div>
                <x-text-input-icon id="footer_telegram" name="footer_telegram" type="text" value="{{ $footerTelegram ?? 'https://t.me/bziksv' }}" class="form-control" required />
                <x-input-error class="mt-2" :messages="$errors->get('footer_telegram')" />
            </div>
        </div>
        <div class="card-footer">
            <x-primary-button>{{ __('Сохранить') }}</x-primary-button>
        </div>
    </form>
</div>
