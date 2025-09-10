<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Кратность товара') }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="input-group input-group-sm">
            <input type="text" class="form-control" data-id="{{ $product->id }}" value="{{ $product->multiplicityProduct }}">
            <span class="input-group-append">
                <button type="button" class="btn btn-info btn-flat" id="multiplicity">{{ __('Сохранить') }}</button>
            </span>
        </div>
    </div>
    <!-- /.card-body -->
</div>

@push('scripts')
    <script>
        $("#multiplicity").click(function () {
            let group = $(this).closest(".input-group");
            let input = group.find(".form-control");

            axios.post('{{ route('products.multiplicity-store') }}', {
                id: input.data('id'),
                val: input.val(),
            }).then(function (response) {
                toastr.success('Успешно сохранено!');
            });
        });
    </script>
@endpush
