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
                    <th style="white-space: nowrap">{{ __('3') }} <i class="far fa-question-circle" data-toggle="tooltip" title="{{ $stocks[3]['dateFrom'] }}"></i></th>
                    <th style="white-space: nowrap">{{ __('5') }} <i class="far fa-question-circle" data-toggle="tooltip" title="{{ $stocks[5]['dateFrom'] }}"></i></th>
                    <th style="white-space: nowrap">{{ __('7') }} <i class="far fa-question-circle" data-toggle="tooltip" title="{{ $stocks[7]['dateFrom'] }}"></i></th>
                    <th style="white-space: nowrap">{{ __('15') }} <i class="far fa-question-circle" data-toggle="tooltip" title="{{ $stocks[15]['dateFrom'] }}"></i></th>
                    <th style="white-space: nowrap">{{ __('30') }} <i class="far fa-question-circle" data-toggle="tooltip" title="{{ $stocks[30]['dateFrom'] }}"></i></th>
                    <th style="white-space: nowrap">{{ __('60') }} <i class="far fa-question-circle" data-toggle="tooltip" title="{{ $stocks[60]['dateFrom'] }}"></i></th>
                    <th style="white-space: nowrap">{{ __('90') }} <i class="far fa-question-circle" data-toggle="tooltip" title="{{ $stocks[90]['dateFrom'] }}"></i></th>
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
                <td>{{ $stocks[3]['count'] }}</td>
                <td>{{ $stocks[5]['count'] }}</td>
                <td>{{ $stocks[7]['count'] }}</td>
                <td>{{ $stocks[15]['count'] }}</td>
                <td>{{ $stocks[30]['count'] }}</td>
                <td>{{ $stocks[60]['count'] }}</td>
                <td>{{ $stocks[90]['count'] }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
