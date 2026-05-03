<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="row mb-2">
        <div class="col-12">
            @if($archived)
                <a href="{{ route('employee.listV2') }}" class="btn bg-gradient-success mr-2">{{ __('Активные сотрудники') }}</a>
            @else
                <a href="{{ route('employee.listV2', ['archived' => 1]) }}" class="btn bg-gradient-secondary mr-2">{{ __('Архив сотрудников') }}</a>
            @endif
            <a href="{{ route('employee.index', $archived ? ['archived' => 1] : []) }}" class="btn btn-outline-secondary">{{ __('Классический вид') }}</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center flex-wrap">
                    <h3 class="card-title mb-0">{{ $pageTitle }} — {{ __('Версия New') }}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="employee-dt-new" class="table table-bordered table-striped w-100"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    @endpush

    @push('scripts')
        <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script>
            (function ($) {
                const archived = @json($archived);
                $('#employee-dt-new').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: @json(route('employee.datatable.json')),
                        data: function (d) {
                            d.archived = archived ? 1 : 0;
                        }
                    },
                    pageLength: 50,
                    order: [[1, 'asc']],
                    columns: [
                        { data: 'externalCode', name: 'externalCode' },
                        { data: 'name', name: 'name' },
                        { data: 'email', name: 'email' },
                        { data: 'fullName', name: 'fullName' },
                        { data: 'status_html', name: 'archived', orderable: true, searchable: false },
                    ],
                });
            })(jQuery);
        </script>
    @endpush
</x-app-layout>
