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
            @foreach($stores as $store)
                <tr>
                    <td>{{ $store['name'] }}</td>
                    <td>{{ $store->stocks->value('quantity', '0') }}</td>
                    <td>{{ $store->reserves->value('quantity', '0') }}</td>
                    <td>{{ $store->transits->value('quantity', '0') }}</td>
                </tr>
            @endforeach
            <tr>
                <th>{{ __('Итог') }}</th>
                <th>{{ $total['stocks'] }}</th>
                <th>{{ $total['reserves'] }}</th>
                <th>{{ $total['transits'] }}</th>
            </tr>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
