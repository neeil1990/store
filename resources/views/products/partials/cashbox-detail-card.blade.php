<div class="card">
    <div class="card-header">
        <h3 class="card-title">Кассовый чек</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <x-title-with-text title="{{ __('Система налогообложения') }}" text="Совпадает с точкой" />
        <x-title-with-text title="{{ __('Признак предмета расчета') }}" text="{{ $product->paymentItemType }}" />
    </div>
    <!-- /.card-body -->
</div>
