<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Остатки по складам') }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{{ __('Склад') }}</th>
                    <th>{{ __('Остаток') }}</th>
                    <th>{{ __('Резерв') }}</th>
                    <th>{{ __('Ожидание') }}</th>
                </tr>
            </thead>

            <tbody>
            @foreach($product->stocks as $stock)
                @continue(empty($stock->stock) && empty($stock->reserve) && empty($stock->inTransit))

                <tr>
                    <td>{{ $stock->name }}</td>
                    <td>{{ $stock->stock }}</td>
                    <td>{{ $stock->reserve }}</td>
                    <td>{{ $stock->inTransit }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3">{{ __('Всего') }}</td>
                <td colspan="1">{{ $product->stock_total }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
