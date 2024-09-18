var SavedFilters = (function ($) {

    SavedFilters = function ($wrapper, options) {
        let that = this;

        that.$wpapper = $wrapper;
        that.$filters = that.$wpapper.find('.filters-item');
        that.$filtersCancel = that.$wpapper.find('#filters-cancel');
        that.$filtersDelete = that.$wpapper.find('#filters-delete');

        that.options = options;
        that.routes = that.options.routes;

        that.bindEvents();
    };

    SavedFilters.prototype.bindEvents = function () {
        let that = this;

        that.$filters.on('change', $.proxy(that.selectedAction, that));
        that.$filtersCancel.on('click', $.proxy(that.canceledAction, that));
        that.$filtersDelete.on('click', $.proxy(that.deletedAction, that));
    };

    SavedFilters.prototype.selectedAction = function (event) {
        let that = this;
        let id = $(event.target).val();
        axios.put([that.routes.update, id].join('/')).then(that.tableReload);
    };

    SavedFilters.prototype.canceledAction = function () {
        let that = this;

        that.$filters.filter(":checked").prop('checked', false);
        axios.put([that.routes.update, 0].join('/')).then(that.tableReload);
    };

    SavedFilters.prototype.deletedAction = function () {
        let that = this;
        let elem = that.$filters.filter(":checked");
        let id = elem.val();
        elem.closest(".col-md-auto").remove();

        axios.delete([that.routes.delete, id].join('/')).then(that.tableReload);
    };

    SavedFilters.prototype.tableReload = function () {
        window.location.reload();
    };

    return SavedFilters;

})(jQuery);
