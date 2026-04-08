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
<script src="{{ asset('plugins/datatables-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-fixedheader/js/fixedHeader.bootstrap4.min.js') }}"></script>
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
                    data.fbo = $('.fbo-filter:checked').val();
                }
            },
            fixedHeader: true,
        });

        $.suppliers.filters = new SavedFilters($(".wrapper"), {
            routes: {
                update: 'filters',
                delete: 'filters',
            },
        });

        // Fix: пересчёт ширины колонок при возврате fixedHeader в исходное состояние
        (function () {
            let table = $.suppliers.$table;

            let observer = new MutationObserver(function (mutations) {
                for (let mutation of mutations) {
                    for (let node of mutation.removedNodes) {
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
        })();

        $("#products-table").on("click", ".input-column", function () {
            let $form = $(this).closest('.input-group');
            let $input = $form.find('input');
            let id = $form.data('id');
            let action = $form.data('action');

            if ($input.val().length > 0 && id) {
                axios.post('{{ route('products.update-field') }}', {
                    id: id,
                    val: $input.val(),
                    field: action
                }).then(function (response) {
                    toastr.success('Успешно сохранено!');
                });
            }

            return true;
        });

        $('[data-toggle="tooltip"]').tooltip({
            'html': true
        });

    })(jQuery);
</script>
