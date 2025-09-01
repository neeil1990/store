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

        <table class="table table-bordered">
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
