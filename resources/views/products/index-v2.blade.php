<x-app-layout>
    <x-slot name="header"></x-slot>

    <x-slot name="sidebar">
        @include('products.partials.products-filter')
    </x-slot>

    <div class="products-v2-page">
        <div class="products-v2-surface">
            <article class="products-v2-shell">
                <header class="products-v2-masthead">
                    <div class="products-v2-masthead-grid">
                        <div class="products-v2-masthead-copy">
                            <span class="products-v2-eyebrow">{{ __('Каталог') }}</span>
                            <h1 class="products-v2-title">{{ __('Товары New') }}</h1>
                            <p class="products-v2-lead">
                                {{ __('Быстрый просмотр остатков и цен: те же данные, что на классической странице «Товары». Фильтры — справа, экспорт — в панели ниже.') }}
                            </p>
                        </div>
                        <div class="products-v2-masthead-cta">
                            <a href="{{ route('products.index') }}" class="btn btn-outline-light btn-sm products-v2-ghost-btn mb-2">
                                <i class="fas fa-th-list mr-1"></i>{{ __('Классический вид') }}
                            </a>
                            <div class="d-block">
                                <a href="#" type="button" class="btn btn-primary btn-sm shadow-sm" data-widget="control-sidebar" data-slide="true">
                                    <i class="fas fa-sliders-h mr-1"></i>{{ __('Фильтр') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="products-v2-masthead-accent" aria-hidden="true"></div>
                </header>

                <div class="products-v2-body">
                    <div class="products-v2-toolbar">
                        <div class="products-v2-toolbar-label">
                            <i class="fas fa-layer-group text-primary mr-2"></i>
                            <span>{{ __('Панель таблицы') }}</span>
                        </div>
                        <div class="products-v2-toolbar-actions btn-list-v2"></div>
                    </div>

                    <div class="products-v2-table-stage">
                        @include('products.partials.products-table-v2')
                    </div>
                </div>
            </article>
        </div>
    </div>

    @push('styles')
        @include('products.partials.styles')
        <style>
            .products-v2-page {
                --pv-primary: #0d6efd;
                --pv-ink: #0b1220;
                --pv-muted: rgba(255, 255, 255, 0.72);
                --pv-panel: #ffffff;
                --pv-line: rgba(13, 110, 253, 0.12);
                margin: -0.5rem -0.75rem 0;
                padding: 0 0.25rem 1.5rem;
            }
            @media (min-width: 992px) {
                .products-v2-page {
                    margin: -0.5rem -1rem 0;
                    padding: 0 0.25rem 2rem;
                }
            }
            .products-v2-surface {
                min-height: calc(100vh - 8rem);
                background:
                    radial-gradient(1200px 500px at 10% -10%, rgba(13, 110, 253, 0.08), transparent 55%),
                    radial-gradient(900px 400px at 90% 0%, rgba(26, 35, 126, 0.06), transparent 50%),
                    linear-gradient(180deg, #eef2f7 0%, #f8fafc 45%, #f1f5f9 100%);
                border-radius: 1rem;
                padding: 1.25rem 1rem 1.75rem;
            }
            .products-v2-shell {
                max-width: 100%;
                margin: 0 auto;
                border-radius: 1rem;
                overflow: hidden;
                background: var(--pv-panel);
                box-shadow:
                    0 1px 1px rgba(15, 23, 42, 0.04),
                    0 12px 40px -12px rgba(15, 23, 42, 0.18);
                border: 1px solid rgba(15, 23, 42, 0.06);
            }
            .products-v2-masthead {
                position: relative;
                padding: 1.75rem 1.75rem 1.5rem;
                background:
                    linear-gradient(125deg, #0b1220 0%, #152238 42%, #1a3a5c 78%, #0f2744 100%);
                color: #fff;
            }
            .products-v2-masthead::after {
                content: '';
                position: absolute;
                inset: 0;
                background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
                opacity: 0.9;
                pointer-events: none;
            }
            .products-v2-masthead-grid {
                position: relative;
                z-index: 1;
                display: flex;
                flex-direction: column;
                gap: 1.25rem;
            }
            @media (min-width: 768px) {
                .products-v2-masthead-grid {
                    flex-direction: row;
                    align-items: flex-end;
                    justify-content: space-between;
                }
            }
            .products-v2-eyebrow {
                display: inline-block;
                font-size: 0.68rem;
                font-weight: 700;
                letter-spacing: 0.16em;
                text-transform: uppercase;
                color: var(--pv-muted);
                margin-bottom: 0.35rem;
            }
            .products-v2-title {
                font-size: 1.65rem;
                font-weight: 800;
                letter-spacing: -0.02em;
                line-height: 1.2;
                margin: 0 0 0.5rem;
                text-shadow: 0 2px 24px rgba(0, 0, 0, 0.25);
            }
            .products-v2-chip {
                display: inline-block;
                vertical-align: middle;
                margin-left: 0.5rem;
                padding: 0.2rem 0.55rem;
                font-size: 0.65rem;
                font-weight: 700;
                letter-spacing: 0.06em;
                text-transform: uppercase;
                border-radius: 999px;
                background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
                color: #1a1a1a;
                box-shadow: 0 2px 8px rgba(255, 193, 7, 0.35);
            }
            .products-v2-lead {
                margin: 0;
                max-width: 38rem;
                font-size: 0.92rem;
                line-height: 1.55;
                color: var(--pv-muted);
            }
            .products-v2-masthead-cta {
                flex-shrink: 0;
                display: flex;
                flex-direction: column;
                align-items: stretch;
            }
            @media (min-width: 768px) {
                .products-v2-masthead-cta {
                    align-items: flex-end;
                }
            }
            .products-v2-ghost-btn {
                border-color: rgba(255, 255, 255, 0.35) !important;
                color: #fff !important;
            }
            .products-v2-ghost-btn:hover {
                background: rgba(255, 255, 255, 0.1) !important;
                border-color: rgba(255, 255, 255, 0.55) !important;
                color: #fff !important;
            }
            .products-v2-masthead-accent {
                position: absolute;
                left: 0;
                right: 0;
                bottom: 0;
                height: 4px;
                background: linear-gradient(90deg, var(--pv-primary), #6610f2 45%, #20c997);
                opacity: 0.95;
            }
            .products-v2-body {
                background: linear-gradient(180deg, #fbfcfe 0%, #fff 28%);
            }
            .products-v2-toolbar {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
                gap: 0.75rem;
                padding: 0.85rem 1.25rem;
                border-bottom: 1px solid var(--pv-line);
                background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
            }
            .products-v2-toolbar-label {
                font-size: 0.8rem;
                font-weight: 600;
                color: #495057;
                text-transform: uppercase;
                letter-spacing: 0.06em;
            }
            .products-v2-toolbar-actions .dt-buttons {
                margin-bottom: 0;
            }
            .products-v2-toolbar-actions .btn {
                border-radius: 0.35rem;
                margin-bottom: 0.15rem;
            }
            .products-v2-table-stage {
                padding: 0 0.25rem 0.75rem;
                background: #fff;
            }
            @media (min-width: 768px) {
                .products-v2-table-stage {
                    padding: 0 1rem 1rem;
                }
            }
            .products-v2-table-stage .dataTables_wrapper {
                padding-top: 0.5rem;
            }
            .products-v2-table-stage .dataTables_length,
            .products-v2-table-stage .dataTables_filter {
                padding: 0.35rem 0.5rem 0.75rem;
            }
            .products-v2-table-stage .dataTables_filter input {
                border-radius: 0.35rem;
                border: 1px solid #ced4da;
                min-width: 12rem;
            }
            .products-v2-table-stage .dataTables_info,
            .products-v2-table-stage .dataTables_paginate {
                padding: 0.65rem 0.5rem 0.35rem;
                font-size: 0.875rem;
            }
            .products-v2-datatable {
                border-collapse: separate;
                border-spacing: 0;
            }
            .products-v2-datatable thead th {
                background: linear-gradient(180deg, #f1f5f9 0%, #e9ecef 100%);
                font-weight: 700;
                font-size: 0.78rem;
                text-transform: uppercase;
                letter-spacing: 0.04em;
                color: #495057;
                white-space: nowrap;
                border-bottom: 2px solid #dee2e6 !important;
                padding-top: 0.65rem;
                padding-bottom: 0.65rem;
            }
            .products-v2-datatable tbody td {
                vertical-align: middle;
                font-size: 0.875rem;
                border-color: #f1f3f5 !important;
            }
            .products-v2-datatable.table-striped tbody tr:nth-of-type(odd) {
                background-color: rgba(248, 250, 252, 0.85);
            }
            .products-v2-table-stage .dataTables_wrapper tbody tr.products-v2-row-hover td,
            .products-v2-table-stage .DTFC_LeftBodyWrapper tbody tr.products-v2-row-hover td,
            .products-v2-datatable tbody tr.products-v2-row-hover td {
                background-color: rgba(13, 110, 253, 0.07) !important;
            }
            .products-v2-table-stage .dataTables_wrapper tbody tr.products-v2-row-selected td,
            .products-v2-table-stage .DTFC_LeftBodyWrapper tbody tr.products-v2-row-selected td,
            .products-v2-datatable tbody tr.products-v2-row-selected td {
                background-color: rgba(13, 110, 253, 0.12) !important;
                box-shadow: inset 4px 0 0 var(--pv-primary);
            }
        </style>
    @endpush

    @push('scripts')
        @include('products.partials.scripts-products-v2')
    @endpush

</x-app-layout>
