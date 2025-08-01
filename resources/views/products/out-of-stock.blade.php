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
                        <div class="col-4" id="control-buttons">
                            <a href="{{ route('products.outOfStock', ['isZero' => 1]) }}" class="btn btn-secondary btn-default btn-sm @if(request('isZero')) active @endif">{{ __('Показать нулевые') }}</a>
                            <a href="{{ route('products.outOfStock') }}" class="btn btn-secondary btn-default btn-sm @if(!request('isZero')) active @endif">{{ __('Показать все') }}</a>
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
                        <div class="col-12 overflow-auto">
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
                                        <th>{{ __('Неснижаемый остаток lager') }}</th>
                                        <th>{{ __('Остаток') }}</th>
                                        <th>{{ __('Обнулен') }}</th>
                                        <th>3</th>
                                        <th>5</th>
                                        <th>7</th>
                                        <th>15</th>
                                        <th>30</th>
                                        <th>60</th>
                                        <th>90</th>
                                        <th>180</th>
                                        <th>365</th>
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
                                            <td>{{ $product->minimumBalanceLager }}</td>
                                            <td>{{ $product->stocks_sum_quantity }}</td>
                                            <td>{{ $product->deleted_stock_total_at }}</td>
                                            <td>{{ $product->stock_zero_3 }}</td>
                                            <td>{{ $product->stock_zero_5 }}</td>
                                            <td>{{ $product->stock_zero_7 }}</td>
                                            <td>{{ $product->stock_zero_15 }}</td>
                                            <td>{{ $product->stock_zero_30 }}</td>
                                            <td>{{ $product->stock_zero_60 }}</td>
                                            <td>{{ $product->stock_zero_90 }}</td>
                                            <td>{{ $product->stock_zero_180 }}</td>
                                            <td>{{ $product->stock_zero_365 }}</td>
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
        <script src="{{ asset('plugins/datatables-select/js/dataTables.select.js') }}"></script>
        <script src="{{ asset('plugins/datatables-select/js/select.bootstrap4.js') }}"></script>
        <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>

        <script>
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
                buttons: [
                    {
                        extend: 'excelHtml5',
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
                    }
                ],
                initComplete: function () {
                    let api = this.api();

                    api.buttons().container().appendTo('#control-buttons');

                    $('.deleted-stock-totals .btn').click(function () {
                        let days = $('.deleted-stock-totals .form-control').val();

                        let start = moment().subtract(days, 'days').format('YYYY-MM-DD HH:mm:ss');
                        let end = moment();

                        api.rows().data().toArray().forEach((el, i) => {
                            let target = moment(el[10], 'YYYY-MM-DD HH:mm:ss');

                            $(api.row("#" + el.DT_RowId).node()).removeClass('highlight');

                            if (target.isBetween(start, end)) {
                                $(api.row("#" + el.DT_RowId).node()).addClass('highlight');
                            }
                        });
                    });
                },
            });
        </script>
    @endpush

</x-app-layout>


