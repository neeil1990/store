<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/suppliers/table.js') }}"></script>
<script src="{{ asset('plugins/suppliers/saved-filters.js') }}"></script>

<script>
    (function($) {

        $.suppliers = new ST($("#products-table"), {
            ajax: {
                url: '{{ route('suppliers.json') }}',
                data: function (data) {
                    data.stores = $('.store-filter:checked').not(":disabled").map(function(){
                        return $(this).val();
                    }).get();

                    data.toBuy = $('.toBuy-filter:checked').val();
                }
            },
        });

        $.suppliers.filters = new SavedFilters($(".wrapper"), {
            routes: {
                update: 'filters',
                delete: 'filters',
            },
        });

    })(jQuery);
</script>
