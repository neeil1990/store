@foreach($storages as $storage)
    {{ $storage['name'] }}: {{ $storage['quantity'] }} <br />
@endforeach

{{ __('Остаток') }}: {{ $sumStock }} <br />
{{ __('Неснижаемый остаток') }}: {{ $minBalance }}
