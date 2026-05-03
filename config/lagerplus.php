<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Кэш UI-бандла settings (AppLayout)
    |--------------------------------------------------------------------------
    |
    | Один ключ кэша: site_title, подвал, computed_at и др. (см. Setting::LAYOUT_VIEW_KEYS).
    | Сброс: SettingController при изменении этих ключей, CalculateFieldsAction после пересчёта.
    | TTL по умолчанию, если в БД нет ключа layout_view_cache_ttl (задаётся в разделе Настройки).
    |
    */

    'settings_layout_cache_ttl' => (int) env('SETTINGS_LAYOUT_CACHE_TTL', 120),

    /*
    |--------------------------------------------------------------------------
    | Кэш выдачи данных (DataTables / JSON)
    |--------------------------------------------------------------------------
    |
    | Единый слой: App\Services\DataOutputCache. Ревизия группы сбрасывается
    | при изменении связанных моделей (см. AppServiceProvider).
    |
    */

    'data_output_cache' => [
        'enabled' => filter_var(env('DATA_OUTPUT_CACHE_ENABLED', true), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? true,
        'ttl_seconds' => max(1, (int) env('DATA_OUTPUT_CACHE_TTL', 300)),
        'store' => env('DATA_OUTPUT_CACHE_STORE'),
    ],

];
