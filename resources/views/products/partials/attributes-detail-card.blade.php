<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Дополнительные поля') }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        @foreach($product->attributes as $attribute)
            @if(is_array($attribute['value']))
                <x-title-with-text title="{{ $attribute['name'] }}" text="{!! $attribute['value']['name'] !!}" />
            @else
                <x-title-with-text title="{{ $attribute['name'] }}" text="{{ $attribute['value'] }}" />
            @endif
        @endforeach
    </div>
    <!-- /.card-body -->
</div>
