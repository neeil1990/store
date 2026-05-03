<x-app-layout>
    <x-slot name="header"></x-slot>

    <x-slot name="sidebar">
        @include('products.partials.products-filter')
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center flex-wrap">
                    <h3 class="card-title mb-0">{{ $pageTitle }}</h3>
                    <span class="ml-auto small">
                        <a href="{{ route('products.listV2') }}" class="text-muted">{{ __('Товары New') }}</a>
                    </span>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-12 btn-list">
                            @include('products.partials.buttons')
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            @include('products.partials.products-table')
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    @push('styles')
        @include('products.partials.styles')
    @endpush

    @push('scripts')
        @include('products.partials.scripts')
    @endpush

</x-app-layout>


