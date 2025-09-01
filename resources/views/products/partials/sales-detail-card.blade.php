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
                    <th>{{ __('Прошло с последнего запроса') }}</th>
                    <th>{{ __('Продано') }}</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($product->sell as $sell)
                    <tr>
                        <td>{{ $sell->created_at->format('d.m.Y H:i:s') }}</td>

                        @if ($loop->first)
                            <td></td>
                        @else
                            <td>
                                В днях: {{ $product->sell[$loop->index - 1]->created_at->diffInDays($sell->created_at) }}
                                В часах: {{ $product->sell[$loop->index - 1]->created_at->diffInHours($sell->created_at) }}
                            </td>
                        @endif

                        <td>{{ $sell->sell }}</td>
                    </tr>
                @endforeach

                <tr>
                    <td></td>
                    <td></td>
                    <td>Всего: {{ $product->sell->pluck('sell')->sum() }}</td>
                </tr>

            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
