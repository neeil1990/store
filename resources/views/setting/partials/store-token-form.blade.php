<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Токен Мой Склад API') }}</h3>
    </div>

    <!-- form start -->
    <form method="post" action="{{ route('setting.store') }}" class="mt-6 space-y-6">
        @csrf

        <div class="card-body">

            @if(session('status') === 'setting-store')
                <div class="callout callout-success alert-dismissible">
                    <p>{{ __('Токен успешно сохранен.') }}</p>
                    <p>{{ __('Он будет использован в Мой Склад API.') }}</p>
                </div>
            @endif

            <x-text-input-icon name="key" type="hidden" value="token" />

            <div class="form-group">
                <x-input-label for="token" :value="__('Токен')" />
                <x-text-input-icon id="token" name="value" type="text" value="{{ $token }}" class="mt-1 block w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('value')" />
            </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <x-primary-button>{{ __('Сохранить') }}</x-primary-button>
        </div>
    </form>
</div>
