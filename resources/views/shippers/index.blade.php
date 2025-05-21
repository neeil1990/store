<x-app-layout>
    <x-slot name="header"></x-slot>

    <x-slot name="sidebar">
        @include('shippers.partials.shippers-filter')
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Поставщики') }}</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">

                    <div class="row buttons mb-2">
                        <div class="col-12"></div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            @include('shippers.partials.products-table')
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    <x-modal-default modal="form-min-sum" :body="$minSumView" :action="route('shipper.minSumUpdate')" />
    <x-modal-default modal="form-fill-storage" :body="$fillStorageView" :action="route('shipper.fillStorageUpdate')" />

    @push('styles')
        @include('shippers.partials.styles')
    @endpush

    @push('scripts')
        @include('shippers.partials.scripts')
    @endpush

</x-app-layout>


