<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="row mb-2">
        <div class="col-12 d-flex flex-wrap align-items-center">
            @can('create user')
                <a href="{{ route('register') }}" class="btn bg-gradient-info mr-2 mb-2">{{ __('Добавить пользователя') }}</a>
            @endcan
            @if($archived)
                <a href="{{ route('users.listV2') }}" class="btn bg-gradient-success mr-2 mb-2">{{ __('Активные пользователи') }}</a>
            @else
                <a href="{{ route('users.listV2', ['archived' => 1]) }}" class="btn bg-gradient-secondary mr-2 mb-2">{{ __('Архив пользователей') }}</a>
            @endif
            <a href="{{ route('users.index', $archived ? ['archived' => 1] : []) }}" class="btn btn-outline-secondary mb-2">{{ __('Классический вид') }}</a>
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
                        <table id="users-dt-new" class="table table-bordered table-striped w-100"></table>
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
                $('#users-dt-new').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: @json(route('users.json')),
                        data: function (d) {
                            d.archived = archived ? 1 : 0;
                        }
                    },
                    pageLength: 50,
                    order: [[0, 'asc']],
                    columns: [
                        { data: 'id', name: 'id', width: '60px' },
                        { data: 'name_html', name: 'name', orderable: true, searchable: true },
                        { data: 'email', name: 'email' },
                        { data: 'department', name: 'department' },
                        { data: 'status_html', name: 'is_archived', orderable: true, searchable: false },
                        { data: 'created_human', name: 'created_at', orderable: true, searchable: false },
                        { data: 'phone', name: 'phone' },
                        { data: 'actions_html', orderable: false, searchable: false, defaultContent: '' },
                    ],
                });
            })(jQuery);
        </script>
    @endpush
</x-app-layout>
