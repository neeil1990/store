<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center flex-wrap">
                    <h3 class="card-title mb-0">{{ $pageTitle }} {{ $title }}</h3>
                    <span class="ml-auto small">
                        <a href="{{ route('products.outOfStock', request()->only('filter')) }}" class="text-muted">{{ __('Классический вид') }}</a>
                    </span>
                </div>

                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-6" id="control-buttons-new"></div>
                        <div class="col-md-4">
                            <label class="small text-muted mb-0" for="oos-filter">{{ __('Фильтр') }}</label>
                            <select id="oos-filter" class="form-control form-control-sm">
                                <option value="">{{ __('Не выбрано') }}</option>
                                <option value="zero" @selected($filter === 'zero')>{{ __('Показать нулевые') }}</option>
                                <option value="zero_no_transits" @selected($filter === 'zero_no_transits')>{{ __('Показать нулевые без ожидания') }}</option>
                                <option value="multiplicity" @selected($filter === 'multiplicity')>{{ __('Без кратности товара') }}</option>
                                <option value="incomplete_pack" @selected($filter === 'incomplete_pack')>{{ __('Неполная упаковка') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <table id="products-zero-new" class="table table-bordered table-striped w-100">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>{{ __('Наименование') }}</th>
                                        <th>{{ __('Поставщик') }}</th>
                                        <th>{{ __('Артикул') }}</th>
                                        <th>{{ __('Код') }}</th>
                                        <th>{{ __('Закупочная цена') }}</th>
                                        <th>{{ __('Неснижаемый остаток') }}</th>
                                        <th>{{ __('Автоматизация цены') }}</th>
                                        <th>{{ __('Предлагаемый нес.ост.') }}</th>
                                        <th>{{ __('Неснижаемый остаток lager') }}</th>
                                        <th>{{ __('Кратность товара') }}</th>
                                        <th>{{ __('Мин.Остаток сч.как 0') }}</th>
                                        <th>{{ __('Кол-во в упаковке') }}</th>
                                        <th>{{ __('% ост. в уп.') }}</th>
                                        <th>{{ __('Остаток') }}</th>
                                        <th>{{ __('Ожидание') }}</th>
                                        <th>{{ __('Обнулен') }}</th>
                                        <th>3</th>
                                        <th>5</th>
                                        <th>7</th>
                                        <th class="days-15">15</th>
                                        <th class="days-15">15</th>
                                        <th class="days-30">30</th>
                                        <th class="days-30">30</th>
                                        <th class="days-60">60</th>
                                        <th class="days-60">60</th>
                                        <th class="days-90">90</th>
                                        <th class="days-90">90</th>
                                        <th class="days-180">180</th>
                                        <th class="days-180">180</th>
                                        <th class="days-365">365</th>
                                        <th class="days-365">365</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/datatables-select/css/select.bootstrap4.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/datatables-fixedcolumns/css/fixedColumns.bootstrap4.min.css') }}">
        <style>
            th { white-space: nowrap; }
            .days-15 { background-color: rgba(12, 132, 255, 0.05); }
            .days-30 { background-color: rgba(13, 255, 146, 0.05); }
            .days-60 { background-color: rgba(223, 14, 255, 0.05); }
            .days-90 { background-color: rgba(255, 199, 15, 0.05); }
            .days-180 { background-color: rgba(16, 255, 191, 0.05); }
            .days-365 { background-color: rgba(255, 17, 17, 0.05); }
            /* Мягче, чем дефолтный #0275d8 у select.bootstrap4 */
            #products-zero-new.table.dataTable tbody > tr.selected,
            #products-zero-new.table.dataTable tbody > tr > .selected {
                background-color: rgba(2, 117, 216, 0.14) !important;
                color: inherit;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
        <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-select/js/dataTables.select.js') }}"></script>
        <script src="{{ asset('plugins/datatables-select/js/select.bootstrap4.js') }}"></script>
        <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-fixedcolumns/js/dataTables.fixedColumns.js') }}"></script>
        <script src="{{ asset('plugins/datatables-fixedcolumns/js/fixedColumns.bootstrap4.js') }}"></script>
        <script src="{{ asset('plugins/datatables-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-fixedheader/js/fixedHeader.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('plugins/products-out-of-stock-new/table.js') }}"></script>
        <script>
            (function ($) {
                const settingsConfig = @json($settings);
                const routes = {
                    json: @json(route('products.outOfStockNew.json')),
                    destroyStockTotals: @json(route('products.destroyStockTotals')),
                    updateField: @json(route('products.update-field')),
                    getSettingBase: @json(url('/products/out-of-stock/settings')),
                    storeSetting: @json(route('products.storeOutOfStockSettings')),
                };
                const isAdmin = {{ auth()->user()->hasRole('administrator') ? 'true' : 'false' }};

                const tbl = window.initOutOfStockNewTable({ routes: routes, isAdmin: isAdmin });

                $('#oos-filter').on('change', function () {
                    const v = $(this).val();
                    const url = new URL(window.location.href);
                    if (v) {
                        url.searchParams.set('filter', v);
                    } else {
                        url.searchParams.delete('filter');
                    }
                    window.history.replaceState({}, '', url);
                    tbl.ajax.reload();
                });

                $('[data-toggle="tooltip"]').tooltip({ html: true });

                function getFormGroupElement(title, key, hint) {
                    return $('<div />', { class: 'form-group' }).append([
                        $('<label />').text(title),
                        $('<i />', {
                            class: 'far fa-question-circle ml-1' + (hint ? '' : ' d-none'),
                            'data-toggle': 'popover',
                            'data-content': hint || ''
                        }),
                        $('<input />', { class: 'form-control form-control-sm', name: key })
                    ]);
                }

                function getFormGroupCheckboxElement(title, key, hint) {
                    return $('<div />', { class: 'form-group' }).append([
                        $('<div />', { class: 'custom-control custom-checkbox' }).append([
                            $('<input />', {
                                type: 'checkbox',
                                class: 'custom-control-input',
                                name: key,
                                id: 'setting-new-' + key
                            }),
                            $('<label />', {
                                class: 'custom-control-label',
                                for: 'setting-new-' + key
                            }).text(title),
                            $('<i />', {
                                class: 'far fa-question-circle ml-1' + (hint ? '' : ' d-none'),
                                'data-toggle': 'popover',
                                'data-content': hint || ''
                            })
                        ])
                    ]);
                }

                window.attachOutOfStockNewSettingsPopover = function () {
                    const popover = $('<div />', { css: { maxHeight: '70vh', overflowY: 'auto' } });

                    settingsConfig.forEach(function (s) {
                        const type = s.type || 'input';
                        if (type === 'separator') {
                            popover.append($('<hr />'));
                            popover.append($('<h6 />', { class: 'font-weight-bold' }).text(s.title));
                            return;
                        }
                        if (type === 'checkbox') {
                            popover.append(getFormGroupCheckboxElement(s.title, s.key, s.hint || ''));
                            return;
                        }
                        popover.append(getFormGroupElement(s.title, s.key, s.hint || ''));
                    });

                    popover.find('[data-toggle="popover"]').popover({
                        container: 'body',
                        boundary: 'window',
                        html: true,
                        trigger: 'hover',
                    });

                    popover.find('input').each(function () {
                        const self = $(this);
                        const key = self.attr('name');
                        axios.get(routes.getSettingBase + '/' + encodeURIComponent(key)).then(function (response) {
                            if (self.attr('type') === 'checkbox') {
                                self.prop('checked', !!parseInt(response.data, 10));
                            } else {
                                self.val(response.data);
                            }
                        });
                    });

                    popover.find('input:not([type="checkbox"])').keyup(function () {
                        const self = $(this);
                        axios.post(routes.storeSetting, {
                            key: self.attr('name'),
                            value: self.val()
                        });
                    });

                    popover.find('input[type="checkbox"]').change(function () {
                        const self = $(this);
                        axios.post(routes.storeSetting, {
                            key: self.attr('name'),
                            value: self.is(':checked') ? 1 : 0
                        });
                    });

                    this.popover(popover, {
                        collectionLayout: 'fixed',
                        closeButton: false,
                        popoverTitle: 'Настройка формулы нес.остатка',
                    });
                };
            })(jQuery);
        </script>
    @endpush
</x-app-layout>
