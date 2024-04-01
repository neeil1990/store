<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ __('Обновить пароль') }}</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="card-body">

            @if (session('status') === 'password-updated')
                <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif

            <div class="form-group">
                <x-input-label for="update_password_current_password" :value="__('Текущий пароль')" />
                <x-text-input-icon id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div class="form-group">
                <x-input-label for="update_password_password" :value="__('Новый пароль')" />
                <x-text-input-icon id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <div class="form-group">
                <x-input-label for="update_password_password_confirmation" :value="__('Подтвердите пароль')" />
                <x-text-input-icon id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <x-primary-button>Сохранить</x-primary-button>
        </div>
    </form>
</div>
