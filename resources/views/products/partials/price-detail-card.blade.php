<div class="card">
    <div class="card-header">
        <h3 class="card-title">Цены</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <x-title-with-text title="{{ __('Минимальная цена') }}" text="{{ $product->minPrice }}" />
        <x-title-with-text title="{{ __('Закупочная цена') }}" text="{{ $product->buyPrice }}" />
        <x-title-with-text title="{{ __('Цена продажи') }}" text="{{ $product->salePrices }}" />
    </div>
    <!-- /.card-body -->
</div>
