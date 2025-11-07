<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Товары с нулевым остатком') }}</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <div class="row mb-2">

                        <div class="col-6" id="control-buttons">
                            <select class="form-control form-control-sm btn-group" style="width: auto;" onchange="if(this.value) window.location.href='{{ route('products.outOfStock') }}?filter=' + this.value; else window.location.href='{{ route('products.outOfStock') }}'">
                                <option value="">{{ __('Не выбрано') }}</option>
                                <option value="zero" @if(request('filter') === 'zero') selected @endif>Показать нулевые</option>
                                <option value="multiplicity" @if(request('filter') === 'multiplicity') selected @endif>Без кратности товара</option>
                            </select>
                        </div>

                        <div class="col-2">
                            <div class="input-group input-group-sm deleted-stock-totals">
                                <input type="number" class="form-control">

                                <span class="input-group-append">
                                    <button type="submit" class="btn btn-info btn-flat">
                                        {{ __('Найти') }}
                                        <i class="far fa-question-circle" data-toggle="tooltip" title="Укажите количество дней, если товар был обнулен в течении этого периода, данная позиция будет подсвечена. Дату и кто обнулял, Вы можете посмотреть в карточке товара"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <table id="products-zero" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
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
                                        <th>{{ __('Остаток') }}</th>
                                        <th>{{ __('Обнулен') }}</th>
                                        <th>3</th>
                                        <th>5</th>
                                        <th>7</th>
                                        <th class="days-15">15 <i class="far fa-question-circle" data-toggle="tooltip" title="Продажи за 15 дней"></i></th>
                                        <th class="days-15">15</th>
                                        <th class="days-30">30 <i class="far fa-question-circle" data-toggle="tooltip" title="Продажи за 30 дней"></i></th>
                                        <th class="days-30">30</th>
                                        <th class="days-60">60 <i class="far fa-question-circle" data-toggle="tooltip" title="Продажи за 60 дней"></i></th>
                                        <th class="days-60">60</th>
                                        <th class="days-90">90 <i class="far fa-question-circle" data-toggle="tooltip" title="Продажи за 90 дней"></i></th>
                                        <th class="days-90">90</th>
                                        <th class="days-180">180 <i class="far fa-question-circle" data-toggle="tooltip" title="Продажи за 180 дней"></i></th>
                                        <th class="days-180">180</th>
                                        <th class="days-365">365 <i class="far fa-question-circle" data-toggle="tooltip" title="Продажи за 365 дней"></i></th>
                                        <th class="days-365">365</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr id="{{ $product->id }}">
                                            <td></td>
                                            <td>
                                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-app m-0" target="_blank"><i class="fas fa-folder"></i>{{ $product->id }}</a>
                                            </td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->suppliers->name }}</td>
                                            <td>{{ $product->article }}</td>
                                            <td>{{ $product->code }}</td>
                                            <td>{{ $product->buyPrice }}</td>
                                            <td>{{ $product->minimumBalance }}</td>
                                            <td>{{ $product->priceAuto }}</td>
                                            <td>{{ $product->sales_formula['minimumBalance'] }}</td>
                                            <td>{{ \App\Services\DataTableViewService::columnInputView(['id' => $product->id, 'value' => $product->minimumBalanceLager, 'action' => route('products.minimum-balance-lager-store')]) }}</td>
                                            <td>{{ \App\Services\DataTableViewService::columnInputView(['id' => $product->id, 'value' => $product->multiplicityProduct, 'action' => route('products.multiplicity-store')]) }}</td>
                                            <td>{{ $product->stocks_sum_quantity }}</td>
                                            <td>{{ $product->deleted_stock_total_at }}</td>
                                            <td>{{ $product->stock_zero_3 }}</td>
                                            <td>{{ $product->stock_zero_5 }}</td>
                                            <td>{{ $product->stock_zero_7 }}</td>
                                            <td class="days-15">{{ $product->sell_15 }}</td>
                                            <td class="days-15">{{ $product->stock_zero_15 }}</td>
                                            <td class="days-30">{{ $product->sell_30 }}</td>
                                            <td class="days-30">{{ $product->stock_zero_30 }}</td>
                                            <td class="days-60">{{ $product->sell_60 }}</td>
                                            <td class="days-60">{{ $product->stock_zero_60 }}</td>
                                            <td class="days-90">{{ $product->sell_90 }}</td>
                                            <td class="days-90">{{ $product->stock_zero_90 }}</td>
                                            <td class="days-180">{{ $product->sell_180 }}</td>
                                            <td class="days-180">{{ $product->stock_zero_180 }}</td>
                                            <td class="days-365">{{ $product->sell_365 }}</td>
                                            <td class="days-365">{{ $product->stock_zero_365 }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/datatables-select/css/select.bootstrap4.css') }}">

        <style>
            .highlight {
                background-color: #ffe79d!important;
            }
            th {
                white-space: nowrap;
            }

            .days-15 {
                background-color: rgba(12, 132, 255, 0.05);
            }
            .days-30 {
                background-color: rgba(13, 255, 146, 0.05);
            }
            .days-60 {
                background-color: rgba(223, 14, 255, 0.05);
            }
            .days-90 {
                background-color: rgba(255, 199, 15, 0.05);
            }
            .days-180 {
                background-color: rgba(16, 255, 191, 0.05);
            }
            .days-365 {
                background-color: rgba(255, 17, 17, 0.05);
            }
            tr.even td.dtfc-fixed-left {
                background-color: #ffffff;
            }
            tr.odd td.dtfc-fixed-left {
                background-color: #f9f9f9;
            }
            thead th {
                background-color: white;
            }
            th.dtfc-fixed-left, th.dtfc-fixed-right, td.dtfc-fixed-left, td.dtfc-fixed-right {
                z-index: 1;
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

        <script>
        const INPUT_COLUMN = [10, 11];

        $.fn.dataTable.ext.order['dom-input'] = function (settings, col) {
            return this.api().column(col, {order:'index'}).nodes().map(function (td, i) {
                return $('input', td).val();
            });
        };

        let table = $('#products-zero').DataTable({
                language: {
                    lengthMenu: '_MENU_',
                    search: 'Поиск _INPUT_',
                    info: 'Показаны с _START_ до _END_ из _TOTAL_ элементов',
                    paginate: {
                        previous: '<',
                        next: '>',
                    }
                },
                lengthMenu: [100, 150, 200, 250, 300],
                order: [[1, 'asc']],
                scrollX: true,
                stateSave: true,
                fixedColumns: {
                    left: 3
                },
                buttons: [
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: ':visible'
                        },
                        title: 'Товары с упущенной выгодой - ' + moment().format('DD-MM-YYYY'),
                        className: 'btn btn-secondary btn-default btn-sm ',
                    },
                    {
                        text: 'Выбрать все',
                        className: 'btn btn-secondary btn-default btn-sm ',
                        action: function () {
                            table.rows().select();
                        }
                    },
                    {
                        text: 'Отменить выбор',
                        className: 'btn btn-secondary btn-default btn-sm ',
                        action: function () {
                            table.rows().deselect();
                        }
                    },
                    {
                        text: 'Обнулить',
                        className: 'btn btn-secondary btn-default btn-sm ',
                        action: function () {
                            if (confirm("Вы точно уверены что хотите обнулить данные, это действие нельзя отменить?")) {
                                let ids = table.rows({ selected: true }).ids();

                                if (ids.length) {
                                    axios.post('{{ route('products.destroyStockTotals') }}', {
                                        ids: ids.toArray()
                                    }).then(function (response) {
                                        window.location.reload();
                                    })
                                }
                            }
                        }
                    },
                    {
                        text: 'Настройки',
                        className: 'btn btn-secondary btn-default btn-sm ',
                        action: function (e, dt, node, config, cb) {
                            e.stopPropagation();

                            let popover = $('<div />');

                            let coefficient = getFormGroupElement('Коэффициент пополнения', 'replenishmentCoefficient');

                            let baseStock = getFormGroupElement('Базовый запас для редких товаров', 'baseStock');

                            let baseStockPrice = getFormGroupElement('Базовый запас для редких товаров стоимостью выше 50 000 (Цена для маркетов)', 'baseStockPrice');

                            let baseStockOverprice = getFormGroupElement('Базовый запас для редких товаров стоимостью выше 50 000 (Значение)', 'baseStockOverprice');

                            let maxMinimumBalance = getFormGroupElement('Коэффициент максимального изменения предлагаемого остатка', 'maxMinimumBalance');

                            popover.append([coefficient, baseStock, baseStockPrice, baseStockOverprice, maxMinimumBalance]);

                            popover.find('input').each(function (i, el) {
                                let self = $(el);
                                axios.get('/products/out-of-stock/settings/' + self.attr('name')).then(function (response) {
                                    self.val(response.data);
                                });
                            });

                            this.popover(popover, {
                                collectionLayout: 'fixed',
                                closeButton: false,
                                popoverTitle: 'Настройка формулы нес.остатка',
                            });

                            popover.find('input').keyup(function () {
                                let self = $(this);
                                let key = self.attr('name');
                                let val = self.val();

                                axios.post('{{ route('products.storeOutOfStockSettings') }}', {
                                    key: key,
                                    value: val
                                }).then(function (response) {
                                    console.log(response);
                                });
                            });
                        },
                    },
                    {
                        extend: 'colvis',
                        text: 'Видимость',
                        className: 'btn btn-default btn-sm',
                    }
                ],
                select: {
                    style: 'os',
                    selector: 'td:first-child'
                },
                columnDefs: [
                    {
                        orderable: false,
                        className: 'select-checkbox',
                        targets: 0
                    },
                    {
                        orderDataType: 'dom-input',
                        type: 'num',
                        targets: INPUT_COLUMN
                    }
                ],
                initComplete: function () {
                    let api = this.api();
                    const resetColumn = 14;

                    api.buttons().container().appendTo('#control-buttons');

                    $('.deleted-stock-totals .btn').click(function () {
                        let days = $('.deleted-stock-totals .form-control').val();

                        let start = moment().subtract(days, 'days').format('YYYY-MM-DD HH:mm:ss');
                        let end = moment();

                        api.rows().data().toArray().forEach((el, i) => {
                            let target = moment(el[resetColumn], 'YYYY-MM-DD HH:mm:ss');

                            $(api.row("#" + el.DT_RowId).node()).removeClass('highlight');

                            if (target.isBetween(start, end)) {
                                $(api.row("#" + el.DT_RowId).node()).addClass('highlight');
                            }
                        });
                    });
                },
            });

            $("#products-zero").on("click", ".input-column", function () {
                let $form = $(this).closest('.input-group');
                let $input = $form.find('input');
                let id = $form.data('id');
                let action = $form.data('action');

                if ($input.val().length > 0 && id) {
                    axios.post(action, {
                        id: id,
                        val: $input.val(),
                    }).then(function (response) {
                        toastr.success('Успешно сохранено!');
                    });
                }

                return true;
            });

            function getFormGroupElement(title, key)
            {
                return $('<div />', {
                    class: 'form-group'
                }).append([
                    $('<label />').text(title),
                    $('<input />', { class: 'form-control form-control-sm', name: key })
                ]);
            }
        </script>
    @endpush

</x-app-layout>


