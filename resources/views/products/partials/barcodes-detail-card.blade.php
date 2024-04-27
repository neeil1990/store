<div class="card">
    <div class="card-header">
        <h3 class="card-title">Штрихкоды товара</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        @foreach($product->barcodes as $barcode)
            <x-title-with-text title="{{ key($barcode) }}" text="{{ $barcode[key($barcode)] }}" />
        @endforeach
    </div>
    <!-- /.card-body -->
</div>
