<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css') }}">
<style>
    /* «Продвинутый поиск» DataTables: заметнее поле + иконка */
    #products-table_wrapper .dataTables_filter {
        float: none;
        text-align: right;
        margin-bottom: 0.75rem;
    }

    #products-table_wrapper .dataTables_filter label {
        display: inline-flex;
        align-items: center;
        flex-wrap: wrap;
        justify-content: flex-end;
        gap: 0.35rem;
        margin-bottom: 0;
        font-weight: 600;
    }

    #products-table_wrapper .dataTables_filter label::before {
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        content: '\f002';
        color: #6c757d;
    }

    #products-table_wrapper .dataTables_filter input[type='search'] {
        min-width: 14rem;
        max-width: 100%;
    }
</style>
