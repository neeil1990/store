<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Редактирование профиля') }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-6">
            @include('profile.partials.update-profile-information-form')

            @include('profile.partials.delete-user-form')
        </div>
        <div class="col-6">
            @include('profile.partials.update-password-form')
        </div>
    </div>

</x-app-layout>
