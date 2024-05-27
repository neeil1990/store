<div class="card">
    <div class="card-header">
        <h3 class="card-title">Общие данные</h3>
        <div class="card-tools">
            <span class="badge badge-success">{{ __('Синхронизировано') }}: {{ $product->updated_at->format('d.m.Y H:i') }}</span>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <x-title-with-text title="{{ __('Наименование') }}" text="{{ $product->name }}" />
        <x-title-with-text title="{{ __('Описание') }}" text="{{ $product->description }}" />
        <x-title-with-text title="{{ __('Группа') }}" text="{{ $product->folder->name }}" />
        <x-title-with-text title="{{ __('Страна') }}" text="{{ $product->countries->name }}" />
        <x-title-with-text title="{{ __('Поставщик') }}" text="{!! $product->suppliers->name !!}" />
        <x-title-with-text title="{{ __('Артикул') }}" text="{{ $product->article }}" />
        <x-title-with-text title="{{ __('Код') }}" text="{{ $product->code }}" />
        <x-title-with-text title="{{ __('Внешний код') }}" text="{{ $product->externalCode }}" />
        <x-title-with-text title="{{ __('Единица измерения') }}" text="{{ $product->uoms->name }}" />
        <x-title-with-text title="{{ __('Вес') }}" text="{{ $product->weight }}" />
        <x-title-with-text title="{{ __('Объем') }}" text="{{ $product->volume }}" />
        <x-title-with-text title="{{ __('НДС') }}" text="{{ $product->vat }}" />
    </div>
    <!-- /.card-body -->
</div>
