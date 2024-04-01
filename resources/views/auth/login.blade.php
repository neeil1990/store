<x-guest-layout>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="/" class="h1"><b>Авторизация</b></a>
            </div>
            <div class="card-body">

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="form-group mb-3">
                        <x-text-input-icon placeholder="Email" id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="form-group mb-3">
                        <x-text-input-icon id="password" placeholder="Пароль"
                                      type="password"
                                      name="password"
                                      required autocomplete="current-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                                <label for="remember_me">Запомнить меня</label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <x-primary-button class="btn-block mb-2">Войти</x-primary-button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mb-1">
                    <a href="{{ route('password.request') }}">Забыл пароль</a>
                </p>
                <p class="mb-0">
                    <a href="{{ route('register') }}" class="text-center">Регистрация</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
</x-guest-layout>
