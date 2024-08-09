var ST = (function($){

    ST = function ($wrapper, options) {
        let that = this;

        that.options = options;

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
            order: [[1, 'asc']],
            lengthMenu: [20, 30, 50, 100],
            searching: false,
            processing: true,
            serverSide: true,
            columns: that.columns(),
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
            { title: 'Артикул', data: 'article' },
            { title: 'Код', data: 'code' },
            { title: 'Закупочная цена', data: 'buyPrice' },
            { title: 'Неснижаемый остаток', data: 'minimumBalance' },
            { title: 'Остаток', data: 'stocks' },
            { title: 'Резерв', data: 'reserve' },
            { title: 'Ожидание', data: 'inTransit' },
            { title: 'К закупке', data: that.toBuyCol, orderable: false },
        ];
    };

    ST.prototype.toBuyCol = function (row) {
        let toBuy = row.stocks - row.minimumBalance - row.reserve - row.inTransit;
        return toBuy;
    };

    return ST;

})(jQuery);
