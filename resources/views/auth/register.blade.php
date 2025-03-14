<x-guest-layout>

    <div class="register-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="/" class="h1"><b>Регистрация</b></a>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="form-group mb-3">
                        <x-text-input-icon placeholder="Имя" id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="form-group mb-3">
                        <x-text-input-icon placeholder="Email" id="email" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="form-group mb-3">
                        <x-text-input-icon placeholder="Пароль" id="password"
                                      type="password"
                                      name="password"
                                      required autocomplete="new-password" />

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
                            <x-primary-button class="btn-block mb-2">Добавить</x-primary-button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

</x-guest-layout>
