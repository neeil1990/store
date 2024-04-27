<div class="card">
    <div class="card-header">
        <h3 class="card-title">Доступ</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <x-title-with-text title="{{ __('Сотрудник') }}" text="{{ $product->employee->name }}" />
        <x-title-with-text title="{{ __('Отдел') }} (В работе)" text="{{ $product->group }}" />
        <x-title-with-text title="{{ __('Общий доступ') }}" text="{{ $product->shared }}" />
    </div>
    <!-- /.card-body -->
</div>
