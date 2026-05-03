<div class="card">
    <div class="card-header">
        @include('setting.partials.card-title-with-hint', [
            'title' => __('Создать токен'),
            'hint' => __('Если в «МойСклад» нужно получить новый access token по логину и паролю аккаунта, заполните поля и нажмите «Создать». Токен появится в сообщении выше — скопируйте его в поле «Мой Склад API токен» в блоке основных настроек и сохраните. Пароль в форме не хранится, используйте только на доверенной машине.'),
        ])
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
