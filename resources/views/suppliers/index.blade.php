<x-app-layout>
    <x-slot name="header"></x-slot>

    <x-slot name="sidebar">
        @include('suppliers.partials.suppliers-filter')
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('К закупке') }}</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-12 btn-list">
                            @include('suppliers.partials.buttons')
                        </div>
                    </div>

                    <div class="row mb-3">
                        @foreach ($filters as $filter)
                            <div class="col-md-auto">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input filters-item" type="radio" id="filters-{{ $filter['id'] }}" name="filters" value="{{ $filter['id'] }}" @if($filter['active']) checked="" @endif>
                                    <label for="filters-{{ $filter['id'] }}" class="custom-control-label">{{ $filter['name'] }}</label>
                                </div>
                            </div>
                            @if ($loop->last)
                                <div class="col-md-auto">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-light btn-xs" id="filters-cancel"><i class="fas fa-power-off"></i> {{ __('Отменить') }}</button>
                                        <button type="button" class="btn btn-light btn-xs" id="filters-delete"><i class="fas fa-ban"></i> {{ __('Удалить') }}</button>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

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

    @include('suppliers.partials.filter-save-modal')

    @push('styles')
        @include('suppliers.partials.styles')
    @endpush

    @push('scripts')
        @include('suppliers.partials.scripts')
    @endpush

</x-app-layout>


