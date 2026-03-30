<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Настройки сайта') }}
        </h2>
    </x-slot>

    <!-- Добавлена ссылка на раздел описаний -->
    <div class="mb-4">
        <a href="{{ route('descriptions.index') }}" class="btn btn-primary">Настройка описании</a>
    </div>

    <div class="row">
        <div class="col-6">
            @include('setting.partials.store-token-form')
            @include('setting.partials.minimum-balance-import')
            @include('setting.partials.warehouse-item-param-form')
        </div>
        <div class="col-6">
            @include('setting.partials.create-token-form')
            @include('setting.partials.measure-item-param-form')
        </div>
    </div>

</x-app-layout>
