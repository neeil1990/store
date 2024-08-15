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
                    text: 'Экспортировать',
                    className: 'btn-default',
                    action: function (e, dt, node, config) {
                        let params = dt.ajax.params();

                        delete params.length;

                        $.extend(params, { exports: ['excel'] });

                        window.location = dt.ajax.url() + '?' + $.param(params);
                    }
                },
            ],
            order: [[1, 'asc']],
            lengthMenu: [30, 50, 100],
            responsive: false,
            autoWidth: false,
            processing: true,
            serverSide: true,
            columns: that.columns(),
            initComplete: function () {
                that.api = this.api();

                that.api.columns().every($.proxy(that.filter, that));
                that.api.buttons().container().appendTo('.btn-list');
            }
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
            { title: 'Код', data: 'code', className: "unsearchable", searchable: false },
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

    return ST;

})(jQuery);
