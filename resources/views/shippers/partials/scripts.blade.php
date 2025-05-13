<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script>
    (function ($) {

        let table = $('#products-table').dataTable({
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
            lengthMenu: [10, 30, 50],
            responsive: false,
            autoWidth: false,
            processing: true,
            serverSide: true,
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

            },
            drawCallback: function (settings) {
                $('[data-toggle="tooltip"]').tooltip({
                    'html': true
                });
            }
        });

    })(jQuery);
</script>
