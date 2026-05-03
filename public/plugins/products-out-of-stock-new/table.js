/**
 * Server-side DataTables: «Товары по упущ.выгоде New».
 */
(function ($) {
    'use strict';

    function columns() {
        return [
            { data: null, defaultContent: '', orderable: false, className: 'select-checkbox' },
            { data: 'name_html', orderable: true, className: 'text-wrap' },
            { data: 'supplier', orderable: true },
            { data: 'article', orderable: true },
            { data: 'code', orderable: true },
            { data: 'buy_price', orderable: true, searchable: false },
            { data: 'minimum_balance', orderable: true, searchable: false },
            { data: 'price_auto', orderable: false, searchable: false },
            { data: 'suggested_minimum', orderable: false, searchable: false },
            { data: 'minimum_balance_lager', orderable: false, searchable: false },
            { data: 'multiplicity_product', orderable: false, searchable: false },
            { data: 'min_balance_counted', orderable: false, searchable: false },
            { data: 'pack_quantity', orderable: true, searchable: false },
            { data: 'pack_pct', orderable: false, searchable: false },
            { data: 'stocks_sum', orderable: true, searchable: false },
            { data: 'transits_sum', orderable: true, searchable: false },
            { data: 'deleted_stock_total_at', orderable: true, searchable: false },
            { data: 'stock_zero_3', searchable: false },
            { data: 'stock_zero_5', searchable: false },
            { data: 'stock_zero_7', searchable: false },
            { data: 'sell_15', className: 'days-15', searchable: false },
            { data: 'stock_zero_15', className: 'days-15', searchable: false },
            { data: 'sell_30', className: 'days-30', searchable: false },
            { data: 'stock_zero_30', className: 'days-30', searchable: false },
            { data: 'sell_60', className: 'days-60', searchable: false },
            { data: 'stock_zero_60', className: 'days-60', searchable: false },
            { data: 'sell_90', className: 'days-90', searchable: false },
            { data: 'stock_zero_90', className: 'days-90', searchable: false },
            { data: 'sell_180', className: 'days-180', searchable: false },
            { data: 'stock_zero_180', className: 'days-180', searchable: false },
            { data: 'sell_365', className: 'days-365', searchable: false },
            { data: 'stock_zero_365', className: 'days-365', searchable: false },
        ];
    }

    window.initOutOfStockNewTable = function (config) {
        const routes = config.routes || {};
        const isAdmin = !!config.isAdmin;

        const table = $('#products-zero-new').DataTable({
            rowId: 'DT_RowId',
            language: {
                processing: 'Обновляем данные, пожалуйста ожидайте',
                lengthMenu: '_MENU_',
                search: 'Поиск _INPUT_',
                info: 'Показаны с _START_ до _END_ из _TOTAL_ элементов',
                paginate: { previous: '<', next: '>' },
            },
            lengthMenu: [25, 50, 100, 200, 300],
            pageLength: 50,
            order: [[1, 'asc']],
            scrollX: true,
            processing: true,
            serverSide: true,
            stateSave: true,
            fixedHeader: true,
            fixedColumns: { left: 2 },
            ajax: {
                url: routes.json,
                type: 'GET',
                data: function (d) {
                    const sel = document.getElementById('oos-filter');
                    d.filter = sel && sel.value ? sel.value : '';
                },
            },
            columns: columns(),
            select: { style: 'os', selector: 'td:first-child' },
            columnDefs: [
                { orderable: false, className: 'select-checkbox', targets: 0 },
            ],
            buttons: [
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible',
                        orthogonal: 'export',
                        format: {
                            body: function (data, row, column, node) {
                                if ($('input', node).length) {
                                    return $('input', node).val();
                                }
                                return $('<div/>').html(data).text();
                            },
                        },
                    },
                    title: 'Товары с упущенной выгодой (New) - ' + moment().format('DD-MM-YYYY'),
                    className: 'btn btn-secondary btn-default btn-sm',
                },
                {
                    text: 'Выбрать все',
                    className: 'btn btn-secondary btn-default btn-sm',
                    action: function () {
                        table.rows({ page: 'current' }).select();
                    },
                },
                {
                    text: 'Отменить выбор',
                    className: 'btn btn-secondary btn-default btn-sm',
                    action: function () {
                        table.rows().deselect();
                    },
                },
                {
                    text: 'Обнулить',
                    className: 'btn btn-secondary btn-default btn-sm',
                    available: function () {
                        return isAdmin;
                    },
                    action: function () {
                        if (!confirm('Вы точно уверены что хотите обнулить данные, это действие нельзя отменить?')) {
                            return;
                        }
                        const ids = table.rows({ selected: true }).ids();
                        if (ids.length) {
                            axios.post(routes.destroyStockTotals, { ids: ids.toArray() }).then(function () {
                                window.location.reload();
                            });
                        }
                    },
                },
                {
                    text: 'Настройки',
                    className: 'btn btn-secondary btn-default btn-sm',
                    available: function () {
                        return isAdmin;
                    },
                    action: function (e, dt, node, config, cb) {
                        e.stopPropagation();
                        if (typeof window.attachOutOfStockNewSettingsPopover === 'function') {
                            window.attachOutOfStockNewSettingsPopover.call(this, e, dt);
                        }
                    },
                },
                {
                    extend: 'colvis',
                    text: 'Видимость',
                    className: 'btn btn-default btn-sm',
                },
            ],
            initComplete: function () {
                const api = this.api();
                api.buttons().container().appendTo('#control-buttons-new');
            },
        });

        $('#products-zero-new').on('click', '.input-column', function () {
            const $form = $(this).closest('.input-group');
            const $input = $form.find('input');
            const id = $form.data('id');
            const action = $form.data('action');
            if ($input.val().length > 0 && id) {
                axios.post(routes.updateField, {
                    id: id,
                    val: $input.val(),
                    field: action,
                }).then(function (response) {
                    if (response.data.success) {
                        toastr.success('Успешно сохранено!');
                    } else {
                        toastr.error(response.data.error || 'Ошибка');
                    }
                });
            }
            return true;
        });

        const observer = new MutationObserver(function (mutations) {
            for (const mutation of mutations) {
                for (const node of mutation.removedNodes) {
                    if (node.nodeType === 1 && node.classList.contains('dtfh-floatingparenthead')) {
                        requestAnimationFrame(function () {
                            table.columns.adjust();
                        });
                        return;
                    }
                }
            }
        });
        observer.observe(document.body, { childList: true });
        table.on('draw.dt', function () {
            table.columns.adjust();
        });

        return table;
    };
})(jQuery);
