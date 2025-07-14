<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Остатки по складам') }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body overflow-auto">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{{ __('Склад') }}</th>
                    <th>{{ __('Остаток') }}</th>
                    <th>{{ __('Резерв') }}</th>
                    <th>{{ __('Ожидание') }}</th>
                    <th>{{ __('3') }}</th>
                    <th>{{ __('5') }}</th>
                    <th>{{ __('7') }}</th>
                    <th>{{ __('15') }}</th>
                    <th>{{ __('30') }}</th>
                    <th>{{ __('60') }}</th>
                    <th>{{ __('90') }}</th>
                </tr>
            </thead>

            <tbody>
            @foreach($stores as $store)
                <tr>
                    <td>{{ $store['name'] }}</td>
                    <td>{{ $store->stocks->value('quantity', '0') }}</td>
                    <td>{{ $store->reserves->value('quantity', '0') }}</td>
                    <td>{{ $store->transits->value('quantity', '0') }}</td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                </tr>
            @endforeach
            <tr>
                <th>{{ __('Итог') }}</th>
                <th>{{ $total['stocks'] }}</th>
                <th>{{ $total['reserves'] }}</th>
                <th>{{ $total['transits'] }}</th>
                <td>{{ $stocks[3] }}</td>
                <td>{{ $stocks[5] }}</td>
                <td>{{ $stocks[7] }}</td>
                <td>{{ $stocks[15] }}</td>
                <td>{{ $stocks[30] }}</td>
                <td>{{ $stocks[60] }}</td>
                <td>{{ $stocks[90] }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
