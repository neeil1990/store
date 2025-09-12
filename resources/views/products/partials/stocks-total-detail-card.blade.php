<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            {{ __('Нулевые остатки по складам') }}
            @if ($product->deleted_stock_total_at && $product->user_who_deleted_stock_total)
                <br />
                {{ __('Обнулен') }} {{ $product->deleted_stock_total_at }} - {{ $product->user_who_deleted_stock_total }}
            @endif
        </h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">

        <table class="table table-bordered" id="zero-balances-in-warehouses">
            <thead>
            <tr>
                <th>{{ __('Дата') }}</th>
                <th>{{ __('Остаток') }}</th>
            </tr>
            </thead>

            <tbody>

            @foreach($product->stockTotal as $stock)
                <tr>
                    <td>{{ $stock['created_at']->format('d.m.Y H:i:s') }}</td>
                    <td>{{ $stock['stock'] }}</td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
    <!-- /.card-body -->

    <div class="card-footer clearfix">
        <a href="{{ route('get-sales-test', $product->id) }}" class="btn btn-default" target="_blank"><i class="fas fa-plus"></i> Тестовая среда</a>
    </div>
</div>

@push('styles')

@endpush

@push('scripts')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $('#zero-balances-in-warehouses').DataTable({
            language: {
                paginate: {
                    previous: '<',
                    next: '>',
                },
            },
            info: false,
            ordering: false,
            searching: false,
            lengthChange: false,
            pageLength: 10,
        });
    </script>
@endpush
