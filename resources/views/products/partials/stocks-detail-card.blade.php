<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Остатки по складам') }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        @foreach($product->stocks as $stock)

            @continue(empty($stock->stock))

            <x-title-with-text title="{{ $stock->name }}" text="{{ $stock->stock }}" />
        @endforeach

        <x-title-with-text title="{{ __('Всего') }}" text="{{ $product->stock_total }}" />
    </div>
    <!-- /.card-body -->
</div>
