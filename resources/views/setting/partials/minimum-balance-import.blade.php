<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Импортировать неснижаемый остаток lager') }}</h3>
    </div>

    <!-- form start -->
    <form method="post" action="{{ route('setting.import') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf

        <div class="card-body">

            @if(session('status') === 'setting-import')
                <div class="callout callout-success alert-dismissible">
                    <p>{{ __('Импорт успешно выполнен!') }}</p>
                    <p>{{ __('Проверьте поле "Неснижаемый остаток lager" в разделах "Товары" и "К закупке"') }}</p>
                </div>
            @endif

            <div class="form-group">
                <label for="customFile">Импорт из Excel</label>
                <div class="custom-file">
                    <input type="file" name="excel" class="custom-file-input" id="customFile">
                    <label class="custom-file-label" for="customFile">Выберите Excel файл</label>
                </div>
                <code>Файл импорта должен содержать "Внешний код"</code>
            </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <x-primary-button>{{ __('Импортировать') }}</x-primary-button>
        </div>
    </form>
</div>

@push('scripts')
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

    <script>
        $(function () {
            bsCustomFileInput.init();
        });
    </script>
@endpush
