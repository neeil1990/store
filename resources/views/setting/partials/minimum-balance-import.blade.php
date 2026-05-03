<div class="card">
    <div class="card-header">
        @include('setting.partials.card-title-with-hint', [
            'title' => __('Импортировать неснижаемый остаток lager'),
            'hint' => __('Массовое обновление поля «Неснижаемый остаток lager» из Excel: в файле должен быть столбец «Внешний код», чтобы сопоставить строки с товарами в базе. Используйте, когда нужно один раз подтянуть остатки из внешней таблицы, а не править каждую позицию вручную.'),
        ])
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
