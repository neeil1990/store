<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('build/vendor/jquery.highlight.js') }}"></script>

<script>
    let table = $("#products-table").DataTable({
        language: {
            lengthMenu: '_MENU_',
            search: 'Поиск _INPUT_',
            info: 'Показаны с _START_ до _END_ из _TOTAL_ элементов',
            paginate: {
                previous: '<',
                next: '>',
            },
        },
        lengthMenu: [10, 50, 100, 300, 400, 500],
        responsive: true,
        autoWidth: false,
        buttons: [
            { extend: 'copy', text: '{{ __('Копировать') }}', className: 'btn-default' },
            { extend: 'csv', text: '{{ __('CSV') }}', className: 'btn-default' },
            { extend: 'excel', text: '{{ __('EXCEL') }}', className: 'btn-default' },
            { extend: 'pdf', text: '{{ __('PDF') }}', className: 'btn-default' },
            { extend: 'print', text: '{{ __('Печать') }}', className: 'btn-default' },
            {
                extend: 'colvis',
                columns: ':not(.noVis)',
                popoverTitle: '{{ __('Видимость столбца') }}',
                text: '{{ __('Столбцы') }}',
                className: 'btn-default'
            }
        ],
        stateSave: true,
        ajax: {
            url: '{{ route('products.json') }}',
            type: 'GET'
        },
        columns: [
            { data: 'name', title: 'Наименование' },
            { data: 'article', title: 'Артикул' },
            { data: 'code', title: 'Код' },
            { data: 'externalCode', title: 'Внешний код' },
            { data: 'salePrices', title: 'Цена продажи' },
            { data: 'minPrice', title: 'Минимальная цена' },
            { data: 'buyPrice', title: 'Закупочная цена' },
        ],
        serverSide: true,
        initComplete: function (settings, json) {
            let api = new $.fn.dataTable.Api( settings );
            api.buttons().container().appendTo('.btn-list');
        }
    });

    table.on( 'draw', function () {
        let body = $( table.table().body() ).find('tr');
        body.find('td:first').highlight(table.search().split(" "));
    });
</script>
