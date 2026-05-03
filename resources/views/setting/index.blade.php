<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center flex-wrap">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0 mr-2">
                {{ __('Настройки сайта') }}
            </h2>
            <i
                class="far fa-question-circle text-info setting-card-hint-icon"
                data-toggle="tooltip"
                data-placement="bottom"
                title="{{ e(__('Эта страница объединяет параметры витрины, интеграции с «МойСклад», импорты, кеш шапки и структуру меню. Меняйте значения осознанно: от них зависят отчёты, синхронизация и то, что видят сотрудники в интерфейсе.')) }}"
                role="img"
                aria-label="{{ __('Справка по странице') }}"
                style="cursor: help; font-size: 1.1rem;"
            ></i>
        </div>
    </x-slot>

    <div class="mb-4">
        <div class="d-flex align-items-start flex-wrap">
            <a href="{{ route('descriptions.index') }}" class="btn btn-primary mr-2 mb-2">{{ __('Настройка описании') }}</a>
            <i
                class="far fa-question-circle text-info mt-2 setting-card-hint-icon"
                data-toggle="tooltip"
                data-placement="bottom"
                title="{{ e(__('Отдельный раздел: тексты-подсказки к полям в формах и сценариях (пояснения для сотрудников). Не путать с кешем шапки: описания редактируются там и подставляются в интерфейсе там, где это предусмотрено в коде.')) }}"
                role="img"
                aria-label="{{ __('Справка') }}"
                style="cursor: help;"
            ></i>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            @include('setting.partials.sidebar-menu-form')
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            @include('setting.partials.site-main-settings-form')
        </div>
        <div class="col-6">
            @include('setting.partials.create-token-form')
            @include('setting.partials.minimum-balance-import')
            @include('setting.partials.layout-cache-settings')
        </div>
    </div>

</x-app-layout>
