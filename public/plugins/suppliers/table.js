var ST = (function($){

    ST = function ($wrapper, options) {
        let that = this;

        that.options = options;

        that.sidebar = document.getElementById("control-sidebar-content");

        that.$table = $wrapper.DataTable(that.config());
    };

    ST.prototype.config = function () {
        let that = this;

        let config = {
            language: {
                lengthMenu: '_MENU_',
                search: 'Поиск _INPUT_',
                info: 'Показаны с _START_ до _END_ из _TOTAL_ элементов',
                paginate: {
                    previous: '<',
                    next: '>',
                },
            },
            buttons: [
                {
                    text: 'Сохранить фильтр',
                    className: 'btn-default',
                    action: function (e, dt, node, config) {
                        let params = dt.ajax.params();
                        let modal = $('#filter-save-modal');

                        delete params.draw;

                        modal.find('input[name="params"]').val(JSON.stringify(params));
                        modal.modal('show');
                    }
                },
                {
                    text: 'Экспортировать',
                    className: 'btn-default',
                    action: function (e, dt, node, config) {
                        let params = dt.ajax.params();

                        delete params.length;

                        $.extend(params, { exports: ['excel'] });

                        window.location = dt.ajax.url() + '?' + $.param(params);
                    }
                }
            ],
            order: [[1, 'asc']],
            lengthMenu: [30, 50, 100],
            responsive: false,
            autoWidth: false,
            processing: true,
            serverSide: true,
            columns: that.columns(),
            stateSave: true,
            stateLoadParams: function (settings, data) {
                let sidebar = $(that.sidebar);

                $.each(data.columns, function (i, el) {
                    el.search.search = '';
                });

                $.ajax({
                    url: '/filters',
                    method: 'GET',
                    async: false,
                    dataType: 'json',
                    data: { active: 1 },
                    success: (payload) => {

                        $.each(payload.columns, function (i, el) {
                            if (el.search.value) {
                                data.columns[i].search.search = el.search.value;
                            }
                        });

                        if (payload.stores.length) {
                            sidebar.find(".store-filter").filter(function () {
                                return payload.stores.indexOf($(this).val()) >= 0;
                            }).prop({'checked' : true});
                        }

                        if (payload.toBuy) {
                            sidebar.find(".toBuy-filter").prop({'checked' : true});
                        }
                    }
                });
            },
            initComplete: function () {
                that.api = this.api();
                that.params = that.api.ajax.params();

                that.api.columns().every($.proxy(that.filter, that));
                that.api.buttons().container().appendTo('.btn-list');
            },
        };

        $.extend(config, that.options);

        return config;
    };

    ST.prototype.columns = function () {
        let that = this;

        return [
            {
                className: "unsearchable",
                searchable: false,
                orderable: false,
                data: 'id',
                render: function(id) {
                    return '<a href="/products/'+ id +'" class="btn btn-app m-0" target="_blank"><i class="fas fa-folder"></i>'+ id +'</a>';
                },
            },
            { title: 'Наименование', data: 'name' },
            { title: 'Поставщик', data: 'suppliers.name' },
            { title: 'Артикул', data: 'article' },
            { title: 'Код', data: 'code', render: that.code },
            { title: 'Закупочная цена', data: 'buyPrice', className: "unsearchable", searchable: false },
            { title: 'Неснижаемый остаток', data: 'minimumBalance', className: "unsearchable", searchable: false },
            { title: 'Остаток', data: 'stock', className: "unsearchable", searchable: false },
            { title: 'Резерв', data: 'reserve', className: "unsearchable", searchable: false },
            { title: 'Ожидание', data: 'transit', className: "unsearchable", searchable: false },
            { title: 'К закупке', data: 'toBuy', className: "unsearchable", searchable: false },
        ];
    };

    ST.prototype.filter = function (event) {
        let that = this;
        let column = that.api.column(event);

        let header = column.header();
        let title = header.textContent;
        let classList = header.classList;

        if(classList.contains("unsearchable"))
            return;

        let group = document.createElement('div');
        group.className = "form-group";

        let label = document.createElement('label');
        label.textContent = title;

        let input = document.createElement('input');
        input.value = column.search();
        input.className = "form-control";

        group.append(label, input);

        input.addEventListener('keyup', () => {
            if (column.search() !== this.value) {
                column.search(input.value).draw();
            }
        });

        that.sidebar.append(group);
    };

    ST.prototype.code = function (data, type, row) {
        return `
        
        <div class="text-center">${row.code}</div>
        <div class="btn-group">
            <a href="https://online.moysklad.ru/app/#good?global_productCodeFilter=${row.article}&global_codeFilter=${row.code}" target="_blank" class="btn btn-light btn-sm">
                <i class="fas fa-warehouse"></i>
            </a>
            <a href="https://online.moysklad.ru/app/#stockReport?reportType=GOODS&typeQuantity=ALL_STOCK&goodIdFilter=[null, null, ${row.name.replaceAll(',', ' ')}, null, null],equals" target="_blank" class="btn btn-light btn-sm">
                <i class="fas fa-chart-pie"></i>
            </a>
        </div>
        `;
    };

    return ST;

})(jQuery);
