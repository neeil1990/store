<x-guest-layout>

    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="/" class="h1"><b>Восстановить пароль</b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Вы всего в одном шаге от нового пароля, восстановите пароль сейчас.</p>
                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div class="form-group mb-3">
                        <x-text-input-icon placeholder="Email" id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="form-group mb-3">
                        <x-text-input-icon placeholder="Новый пароль" id="password" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group mb-3">
                        <x-text-input-icon placeholder="Подтвердить пароль" id="password_confirmation"
                                      type="password"
                                      name="password_confirmation" required autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <x-primary-button class="btn-block">Сохранить</x-primary-button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="{{ route('login') }}">Войти</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
</x-guest-layout>
