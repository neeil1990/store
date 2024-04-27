<div class="card">
    <div class="card-header">
        <h3 class="card-title">Кассовый чек</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <x-title-with-text title="{{ __('Система налогообложения') }} (В работе)" text="taxSystem" />
        <x-title-with-text title="{{ __('Признак предмета расчета') }}" text="{{ $product->paymentItemType }}" />
    </div>
    <!-- /.card-body -->
</div>
