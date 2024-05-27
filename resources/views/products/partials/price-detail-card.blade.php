<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Цены') }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        @foreach($product->prices as $price)
            <x-title-with-text title="{{ $price['name'] }}" text="{{ $price['value'] }}" />
        @endforeach
    </div>
    <!-- /.card-body -->
</div>
