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
        </div>

        <div class="col-4">
            @include('products.partials.barcodes-detail-card')
            @include('products.partials.access-detail-card')
            @include('products.partials.attributes-detail-card')
        </div>
    </div>

    @push('styles')

    @endpush

    @push('scripts')

    @endpush

</x-app-layout>
