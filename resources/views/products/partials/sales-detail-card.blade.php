<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Продажи') }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>{{ __('Дата') }}</th>
                <th>{{ __('Продано') }}</th>
            </tr>
            </thead>

            <tbody>
                <tr>
                    @foreach ($product->sell as $sell)
                        <td>{{ $sell->created_at->format('d.m.Y H:i:s') }}</td>
                        <td>{{ $sell->sell }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td colspan="2" class="text-right">Всего: {{ $product->sell->pluck('sell')->sum() }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
