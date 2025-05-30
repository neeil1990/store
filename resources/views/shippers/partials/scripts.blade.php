<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>

<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script>
    (function ($) {

        let table = $('#products-table').DataTable({
            language: {
                lengthMenu: '_MENU_',
                search: 'Поиск _INPUT_',
                info: 'Показаны с _START_ до _END_ из _TOTAL_ элементов',
                paginate: {
                    previous: '<',
                    next: '>',
                },
            },
            ordering: false,
            order: [[0, 'asc']],
            lengthMenu: [3, 5, 10, 30, 50],
            responsive: false,
            autoWidth: false,
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: {
                url: '{{ route('shipper.json') }}',
                data: function (data) {

                }
            },
            columns: [
                { data: 'id', title: '{{ __('№') }}' },
                { data: 'name', title: '{{ __('Поставщик') }}' },
                { data: 'employee', title: '{{ __('Привязан сотрудник') }}' },
                { data: 'filter', title: '{{ __('Фильтр ') }}' },
                { data: 'min_sum', title: '{{ __('Мин. сумма закупки') }}' },
                { data: 'fill_storage', title: '{{ __('Наполняемость склада, %') }}' },
                { data: 'fill', title: '{{ __('Наполняемость, %') }}' },
                { data: 'fillByStorage', title: '{{ __('Наполняемость по складам, %') }}' },
                { data: 'quantity', title: '{{ __('Кол-во товаров всего') }}' },
                { data: 'to_buy', title: '{{ __('К закупке') }}' },
                { data: 'total_cost', title: '{{ __('Общая сумма закупки по поставщику') }}' },
                { data: 'sender', title: '{{ __('Авто рассылка') }}' },
                { data: 'text_for_sender', title: '{{ __('Текст для рассылки') }}' },
                { data: 'export', title: '{{ __('Экспорт') }}' },
                { data: 'stat', title: '{{ __('Статистика') }}' },
                { data: 'edit', title: '{{ __('Редактирование') }}' }
            ],
            initComplete: function () {
                let api = this.api();

                let quantity = 8;
                hintHeader(quantity, '{{ __('Сумма товаров с указанным неснижаемым остатком') }}');

                let fillByStorage = 7;
                hintHeader(fillByStorage, '{{ __('Именно по выбранным складам') }}');

                let fill = 6;
                hintHeader(fill, '{{ __('По всем складам') }}');

                tooltip();

                api.buttons().container().prependTo('.buttons .col-12');
            },
            drawCallback: function (settings) {
                tooltip();
            },
            buttons: [
                {
                    className: 'btn btn-default btn-sm',
                    text: 'Мин. сумма закупки',
                    attr: {
                        "data-toggle": 'modal',
                        "data-target": '#form-min-sum',
                    },
                    available: function (dt, config) {
                        return {{ auth()->user()->can('update min sum') }};
                    }
                },
                {
                    className: 'btn btn-default btn-sm',
                    text: 'Наполняемость склада, %',
                    attr: {
                        "data-toggle": 'modal',
                        "data-target": '#form-fill-storage',
                    },
                    available: function (dt, config) {
                        return {{ auth()->user()->can('update fill storage') }};
                    }
                },
                {
                    extend: 'spacer',
                    style: 'bar',
                    text: 'Настройка столбцов',
                },
                {
                    extend: 'colvis',
                    collectionLayout: 'fixed columns',
                    text: 'Видимость столбцов',
                    popoverTitle: 'Контроль видимости столбцов',
                    className: 'btn btn-default btn-sm',
                },
                {
                    extend: 'colvisGroup',
                    className: 'btn btn-default btn-sm',
                    text: 'Показать все',
                    show: ':hidden'
                }
            ]
        });

    })(jQuery);

    function tooltip()
    {
        $('[data-toggle="tooltip"]').tooltip({
            'html': true
        });
    }

    function hintHeader(index, text)
    {
        let column = $('#products-table thead').find('th').get(index);

        if (column) {
            $(column).attr({
                'data-toggle': 'tooltip',
                title: text
            }).append($('<i />', {'class': 'far fa-question-circle ml-1'}));
        }
    }
</script>
