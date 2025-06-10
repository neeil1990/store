@foreach($warehouses as $warehouse)
    {{ $warehouse['name'] }}: {{ $warehouse['quantity'] }} <br />
@endforeach

Остаток: {{ $stock }} <br />
Неснижаемый остаток: {{ $balance }} <br />
