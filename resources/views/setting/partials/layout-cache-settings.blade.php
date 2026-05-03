<div class="card">
    <div class="card-header">
        @include('setting.partials.card-title-with-hint', [
            'title' => __('Кеш интерфейса (шапка, подвал, дата пересчёта)'),
            'hint' => __('Чтобы не запрашивать одни и те же настройки из БД на каждой странице, название сайта, подвал и дата пересчёта полей кешируются на заданное время (TTL). После смены настроек или пересчёта кеш обычно сбрасывается сам; «Сбросить кеш» — если нужно немедленно увидеть свежие данные. Больше TTL — меньше нагрузка на БД, но дольше возможна «устаревшая» подпись в шапке.'),
        ])
    </div>
    <div class="card-body">
        @if(session('status') === 'setting-cache-updated')
            <div class="callout callout-success alert-dismissible mb-3">
                <p>{{ __('Время жизни кеша сохранено, кеш сброшен.') }}</p>
            </div>
        @endif
        @if(session('status') === 'setting-cache-flushed')
            <div class="callout callout-success alert-dismissible mb-3">
                <p>{{ __('Кеш сброшен. Данные подтянутся из базы при следующем запросе.') }}</p>
            </div>
        @endif
        <p class="text-muted small mb-3">
            {{ __('Чтобы не дергать базу на каждой странице, настройки шапки и подвала кешируются. После смены настроек сайта кеш обычно сбрасывается сам; кнопка ниже — для принудительного обновления.') }}
        </p>
        <form method="post" action="{{ route('setting.updateLayoutCache') }}" class="mb-4">
            @csrf
            <div class="form-group">
                <x-input-label for="layout_view_cache_ttl" :value="__('Время жизни кеша, секунды (10–604800)')" />
                <x-text-input-icon
                    id="layout_view_cache_ttl"
                    name="layout_view_cache_ttl"
                    type="number"
                    min="10"
                    max="604800"
                    step="1"
                    value="{{ old('layout_view_cache_ttl', $layoutViewCacheTtl ?? 120) }}"
                    class="mt-1 block w-full"
                    required
                />
                <x-input-error class="mt-2" :messages="$errors->get('layout_view_cache_ttl')" />
            </div>
            <x-primary-button type="submit">{{ __('Сохранить TTL') }}</x-primary-button>
        </form>
        <form method="post" action="{{ route('setting.flushLayoutCache') }}" onsubmit="return confirm(@json(__('Сбросить кеш сейчас?')))">
            @csrf
            <button type="submit" class="btn btn-outline-secondary">{{ __('Сбросить кеш сейчас') }}</button>
        </form>
    </div>
</div>
