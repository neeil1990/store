<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/suppliers/table.js') }}"></script>

<script>
    (function($) {

        $.suppliers = new ST($("#products-table"), {
            ajax: '{{ route('suppliers.json') }}',
        });

    })(jQuery);
</script>
