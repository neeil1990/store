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
                @if($attribute['type'] == 'file')
                    <strong>{{ $attribute['name'] }}</strong>
                    <p class="text-muted">
                        <a href="{{ str_replace('https://api.moysklad.ru/api/remap/1.2/download/', 'https://online.moysklad.ru/app/download/', $attribute['download']['href']) }}">
                            {{ $attribute['value'] }}
                        </a>
                    </p>
                    <hr>
                @else
                    <x-title-with-text title="{{ $attribute['name'] }}" text="{{ $attribute['value'] }}" />
                @endif
            @endif
        @endforeach
    </div>
    <!-- /.card-body -->
</div>

