<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="row">
        <div class="col-4">
            @include('products.partials.main-data-detail-card')
        </div>

        <div class="col-4">
            @include('products.partials.price-detail-card')
            @include('products.partials.cashbox-detail-card')
            @include('products.partials.mark-detail-card')
            @include('products.partials.minimum-balance-detail-card')
            @include('products.partials.minimum-balance-lager-detail-card')
            @include('products.partials.multiplicity')
            @include('products.partials.stocks-detail-card')
            @include('products.partials.stocks-total-detail-card')
            @include('products.partials.sales-detail-card')
        </div>

        <div class="col-4">
            @include('products.partials.barcodes-detail-card')
            @include('products.partials.access-detail-card')
            @include('products.partials.attributes-detail-card')
            @include('products.partials.sales-formula')
        </div>
    </div>

    @push('styles')

    @endpush

    @push('scripts')

    @endpush

</x-app-layout>
