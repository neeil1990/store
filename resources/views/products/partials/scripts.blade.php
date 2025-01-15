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
            search: 'Продвинутый поиск _INPUT_',
            info: 'Показаны с _START_ до _END_ из _TOTAL_ элементов',
            paginate: {
                previous: '<',
                next: '>',
            },
        },
        lengthMenu: [10, 50, 100, 300, 400, 500],
        responsive: false,
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
            type: 'GET',
            data: function (data) {
                data.fbo = $('.fbo-filter:checked').val();
            }
        },
        order: [[1, 'asc']],
        columns: [
            {
                className: "unsearchable",
                searchable: false,
                orderable: false,
                data: 'id',
                render: function(id) {
                    return '<a href="/products/'+ id +'" class="btn btn-app m-0"><i class="fas fa-folder"></i>'+ id +'</a>';
                },
            },
            { data: 'name', title: 'Наименование' },
            { data: 'owner', title: 'Сотрудник' },
            { data: 'article', title: 'Артикул' },
            { data: 'code', title: 'Код' },
            { data: 'externalCode', title: 'Внешний код' },
            { title: 'Неснижаемый остаток', data: 'minimumBalance'},
            { title: 'Неснижаемый остаток lager', render: function (data, type, row) {
                    return $('<input />', {
                        type: 'number',
                        value: row.minimumBalanceLager,
                        class: "form-control form-control-border form-control-sm minimum-balance-lager",
                        "data-id": row.id,
                    })[0].outerHTML;
                } },
            { data: 'salePrices', title: 'Цена продажи' },
            { data: 'minPrice', title: 'Минимальная цена' },
            { data: 'buyPrice', title: 'Закупочная цена' },
            { data: 'stockPercent', title: 'Процент остатка' },
        ],
        serverSide: true,
        initComplete: function (settings, json) {
            let api = new $.fn.dataTable.Api( settings );
            api.buttons().container().appendTo('.btn-list');

            let sidebar = document.getElementById("control-sidebar-content");

            api.columns().every(function(){
                let column = this;
                let header = column.header();
                let title = header.textContent;
                let classList = header.classList;

                if(classList.contains("unsearchable"))
                    return;

                let group = document.createElement('div');
                group.className = "form-group";

                let label = document.createElement('label');
                label.textContent = title;

                if(column.dataSrc() === 'owner')
                {
                    let select = document.createElement('select');
                    select.className = "form-control";
                    select.add(new Option('Найти', ''));

                    group.append(label, select);

                    axios.get('{{ route('employee.json') }}')
                        .then(function (response) {
                            $.each(response.data, function (i, el) {
                                select.add(new Option(el.name, el.uuid));
                            });
                        });

                    select.addEventListener('change', function () {
                        column.search(select.value, {exact: true}).draw();
                    });
                }
                else{
                    let input = document.createElement('input');
                    input.value = column.search();
                    input.placeholder = title;
                    input.className = "form-control";

                    group.append(label, input);

                    input.addEventListener('keyup', () => {
                        if (column.search() !== this.value) {
                            column.search(input.value).draw();
                        }
                    });
                }

                sidebar.append(group);
            });

            let clear = document.createElement('button');
            clear.className = "btn btn-block btn-outline-danger btn-xs";
            clear.textContent = "Очистить";
            sidebar.append(clear);

            clear.addEventListener('click', () => {
                table.search('').columns().search('').draw();
                for (const input of sidebar.querySelectorAll(".form-control")) {
                    input.value = "";
                }
            });
        }
    });

    table.on( 'draw', function () {
        let body = $( table.table().body() ).find('tr');
        body.find('td:nth-child(2)').highlight(table.search().split(" "));
    });

    $("#products-table").on("focusout", ".minimum-balance-lager", function () {
        axios.post('{{ route('products.minimum-balance-lager-store') }}', {
            id: $(this).data('id'),
            val: $(this).val(),
        }).then(function (response) {
            toastr.success('Успешно сохранено!');
        });
    });
</script>
