<div class="card card-danger">
    <div class="card-header">
        <h3 class="card-title">Удалить аккаунт</h3>
    </div>
    <div class="card-body">
        <form method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')

            <p class="mt-1 text-sm text-gray-600">
                {{ __('После удаления вашей учетной записи все ее ресурсы и данные будут удалены без возможности восстановления. Пожалуйста, введите свой пароль, чтобы подтвердить, что вы хотите навсегда удалить свою учетную запись.') }}
            </p>

            <div class="form-group">
                <x-input-label for="password" value="{{ __('Пароль') }}" class="sr-only" />
                <x-text-input-icon
                        id="password"
                        name="password"
                        type="password"
                        class="mt-1 block w-3/4"
                        placeholder="{{ __('Пароль') }}"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="form-group">
                <x-danger-button class="btn-flat">
                    {{ __('Удалить аккаунт') }}
                </x-danger-button>
            </div>
        </form>
    </div>
    <!-- /.card-body -->
</div>

