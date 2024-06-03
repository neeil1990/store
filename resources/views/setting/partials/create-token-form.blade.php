<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Создать токен') }}</h3>
    </div>

    <!-- form start -->
    <form method="post" action="{{ route('token.create') }}" class="mt-6 space-y-6">
        @csrf

        <div class="card-body">

            @if(session('token'))
                <div class="callout callout-success">
                    <h5>{{ __('Ваш новый токен сгенерирован, запишите его чтобы не забыть.') }}</h5>

                    <p class="text-success">{{ session('token') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="callout callout-danger">
                    <p class="text-danger">{{ session('error') }}</p>
                </div>
            @endif

            <div class="form-group">
                <x-input-label for="login" :value="__('Логин')" />
                <x-text-input-icon id="login" name="login" type="text" class="mt-1 block w-full" placeholder="admin@romashka" required />
                <x-input-error class="mt-2" :messages="$errors->get('login')" />
            </div>

            <div class="form-group">
                <x-input-label for="password" :value="__('Пароль')" />
                <x-text-input-icon id="password" name="password" type="text" class="mt-1 block w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('password')" />
            </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <x-primary-button>Создать</x-primary-button>
        </div>
    </form>
</div>
