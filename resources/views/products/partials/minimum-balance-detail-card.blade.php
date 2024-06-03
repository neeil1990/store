<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Неснижаемый остаток') }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <x-title-with-text title="{{ __('В сумме на всех складах') }}" text="{{ $product->minimumBalance }}" />
    </div>
    <!-- /.card-body -->
</div>
