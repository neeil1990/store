@props([
    'href' => null,
    'variant' => 'login',
])

@php
    $href = $href ?? url('/');
    $wrap = $variant === 'register' ? 'register-logo' : 'login-logo';
@endphp

<div class="{{ $wrap }}">
    {{-- Плашка: всегда читаемо (не зависит от фона и загрузки картинки). Иконка склада — Font Awesome из кита. --}}
    <a href="{{ $href }}"
       class="d-inline-flex align-items-center bg-white text-dark rounded shadow text-decoration-none px-4 py-2"
       style="font-size: 1.25rem;">
        <i class="fas fa-warehouse text-primary mr-2" aria-hidden="true"></i>
        <span class="font-weight-bold">{{ config('app.name', 'LagerPlus') }}</span>
    </a>
    <p class="mb-0 mt-2 small text-center px-2"
       style="color: rgba(255, 255, 255, 0.92); text-shadow: 0 1px 2px rgba(0, 0, 0, 0.45);">
        Оцифровка склада и остатков
    </p>
</div>
