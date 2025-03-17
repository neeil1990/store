<x-guest-layout>

    <div class="register-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="/" class="h1"><b>Редактировать</b></a>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('users.update', $user->id) }}">
                @method('PATCH')
                @csrf

                <!-- Name -->
                    <div class="form-group mb-3">
                        <x-text-input-icon :placeholder="$user->name" id="name" type="text" name="name" :value="old('name')" autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="form-group mb-3">
                        <x-text-input-icon :placeholder="$user->email" id="email" type="email" name="email" :value="old('email')" autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <x-primary-button class="btn-block mb-2">Изменить</x-primary-button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <p class="mb-1">
                    <a href="{{ route('users.index') }}">Вернуться</a>
                </p>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

</x-guest-layout>
