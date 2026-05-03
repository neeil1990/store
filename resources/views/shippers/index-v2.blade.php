<x-app-layout>
    <x-slot name="header"></x-slot>

    <x-slot name="sidebar">
        @include('shippers.partials.shippers-filter')
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center flex-wrap">
                    <h3 class="card-title mb-0">{{ $pageTitle }} — {{ __('Версия New') }}</h3>
                    <span class="ml-auto small">
                        <a href="{{ route('shipper.index') }}" class="text-muted">{{ __('Классический вид') }}</a>
                    </span>
                </div>

                <div class="card-body">
                    <div class="row">
                        @if ($computedAt)
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-info"><i class="fas fa-calculator"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">{{ __('Дата обновления вычисляемых полей') }}</span>
                                    <span class="info-box-number">{{ $computedAt }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="row buttons mb-2">
                        <div class="col-12"></div>
                    </div>

                    <div class="row">
                        <div class="col-12 overflow-auto">
                            @include('shippers.partials.products-table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-modal-default modal="form-min-sum" :body="view('shippers.cards.form-min-sum')->render()" :action="route('shipper.bulkUpdate', 'min_sum')" />
    <x-modal-default modal="form-fill-storage" :body="view('shippers.cards.form-fill-storage')->render()" :action="route('shipper.bulkUpdate', 'fill_storage')" />
    <x-modal-default modal="form-warehouses" :body="view('shippers.cards.form-warehouses')->render()" :action="route('shipper.bulkUpdateWarehouse')" />

    @push('styles')
        @include('shippers.partials.styles')
    @endpush

    @push('scripts')
        @include('shippers.partials.scripts')
    @endpush

</x-app-layout>
