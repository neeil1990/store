<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Нулевые остатки по складам') }}</h3>
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
</div>
