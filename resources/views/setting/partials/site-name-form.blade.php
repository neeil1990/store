<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Название сайта (Site Name)') }}</h3>
    </div>

    <form method="post" action="{{ route('setting.store') }}" class="mt-6 space-y-6">
        @csrf
        <div class="card-body">
            @if(session('status') === 'setting-store')
                <div class="callout callout-success alert-dismissible">
                    <p>{{ __('Название сайта успешно сохранено.') }}</p>
                </div>
            @endif

            <x-text-input-icon name="key" type="hidden" value="site_name" />

            <div class="form-group">
                <x-input-label for="site_name" :value="__('Название сайта')" />
                <x-text-input-icon id="site_name" name="value" type="text" value="{{ $siteName ?? '' }}" class="mt-1 block w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('value')" />
            </div>
        </div>

        <div class="card-footer">
            <x-primary-button>{{ __('Сохранить') }}</x-primary-button>
        </div>
    </form>
</div>
