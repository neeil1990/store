<div class="card card-secondary">
    <div class="card-header">
        <h3 class="card-title">{{ __('Детальная информация') }}</h3>
    </div>

    <div class="card-body">
        <x-forms.text-group label="{{ __('Минимальная сумма закупки') }}" name="min_sum" value="{{ $shipper->min_sum }}"/>

        <x-forms.text-group label="{{ __('Наполняемость склада, %') }}" name="fill_storage" value="{{ $shipper->fill_storage }}"/>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
