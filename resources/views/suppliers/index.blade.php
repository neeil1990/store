<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Поставщики') }}</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            @include('suppliers.partials.products-table')
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    @push('styles')
        @include('suppliers.partials.styles')
    @endpush

    @push('scripts')
        @include('suppliers.partials.scripts')
    @endpush

</x-app-layout>


