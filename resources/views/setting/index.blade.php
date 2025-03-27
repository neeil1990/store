<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Настройки сайта') }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-6">
            @include('setting.partials.store-token-form')
            @include('setting.partials.minimum-balance-import')
        </div>
        <div class="col-6">
            @include('setting.partials.create-token-form')
        </div>
    </div>

</x-app-layout>
