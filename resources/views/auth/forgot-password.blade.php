<x-guest-layout>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="/" class="h1"><b>Забыли пароль?</b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Без проблем. Просто сообщите нам свой адрес электронной почты, и мы вышлем вам ссылку для сброса пароля, которая позволит вам выбрать новый.</p>
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="form-group mb-3">
                        <x-text-input-icon placeholder="Email" id="email" type="email" name="email" :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <x-primary-button class="btn-block">
                                Запросить новый пароль
                            </x-primary-button>
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
