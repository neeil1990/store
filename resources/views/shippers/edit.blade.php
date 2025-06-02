<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Редактировать поставщика') }}</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <form method="POST" action="{{ route('shipper.update', $id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                @include('shippers.cards.form-general')
                            </div>

                            <div class="col-md-6">
                                @include('shippers.cards.form-details')
                                @include('shippers.cards.form-filter')
                                @include('shippers.cards.form-storage')
                                @include('shippers.cards.form-sender')
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <a href="{{ route('shipper.index') }}" class="btn btn-secondary">{{ __('Вернуться') }}</a>
                                <input type="submit" value="{{ __('Сохранить') }}" class="btn btn-success float-right">
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    @push('styles')
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    @endpush

    @push('scripts')
        <!-- Select2 -->
        <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

        <script>
            (function ($) {

               $('.select2').select2();

            })(jQuery);
        </script>
    @endpush

</x-app-layout>


