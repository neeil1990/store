<x-app-layout>
    <x-slot name="header"></x-slot>

    <x-slot name="sidebar">
        @include('products.partials.products-filter')
    </x-slot>

    <div class="row">
        <div class="col-12 mb-2">
            @include('products.partials.buttons')
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @include('products.partials.products-table')
        </div>
    </div>

    @push('styles')
        @include('products.partials.styles')
    @endpush

    @push('scripts')
        @include('products.partials.scripts')
    @endpush

</x-app-layout>


