<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Формула продаж') }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <ul>
            <li>Базовый запас для редких товаров стоимостью выше 50 000 (Цена) - {{ $salesFormula['baseStockPrice'] }}</li>
            <li>Базовый запас для редких товаров стоимостью выше 50 000 (Значение) - {{ $salesFormula['baseStockOverprice'] }}</li>
            <li>Коэффициент пополнения - {{ $salesFormula['replenishmentCoefficient'] }}</li>
            <li>Дней отсутствия за 30 дней - {{ $salesFormula['unavailable_days_count'] }}</li>
            <li>Продажи за 30 дней - {{ $salesFormula['last_sell_sum'] }}</li>
            <li>Средний спрос - {{ $salesFormula['middleSupply'] }}</li>
            <li>Базовый запас для редких товаров - {{ $salesFormula['baseStock'] }}</li>
            <li>Неснижаемый остаток - {{ $salesFormula['minimumBalance'] }}</li>
            <li>Значение кол-ва в упаковке - {{ $salesFormula['minimumBalanceInPack'] }}</li>
            <li>Коэффициент максимального изменения предлагаемого остатка - {{ $salesFormula['maxMinimumBalance'] }}</li>
        </ul>

        <label for="">Средний спрос</label>
        <pre>Берем 30 дней и вычитаем "Дней отсутствия за 30 дней" если больше 0 тогда "Продажи за 30 дней" / "На полученную разность дней" иначе 0</pre>
        <pre>(30 - {{ $salesFormula['unavailable_days_count'] }}) = {{ 30 - $salesFormula['unavailable_days_count'] }}</pre>
        @if (30 - $salesFormula['unavailable_days_count'] > 0)
            <pre>{{$salesFormula['last_sell_sum']}} / {{30 - $salesFormula['unavailable_days_count']}} = {{round($salesFormula['last_sell_sum'] / (30 - $salesFormula['unavailable_days_count']), 2)}}</pre>
        @else
            <pre>0</pre>
        @endif

        <label for="">Базовый запас для редких товаров</label>
        <pre>Если "Продажи за 30 дней" меньше или равны 1 тогда будет значение из настройки "Базовый запас для редких товаров". Если значения нет, тогда будет 2. Иначе будет 0</pre>
        <pre>{{$salesFormula['last_sell_sum']}} <= 1 = ({{($salesFormula['last_sell_sum'] <= 1) ? "true" : "false"}})</pre>
        @if ($salesFormula['last_sell_sum'] <= 1)
            <pre>Базовый запас для редких товаров = {{ $salesFormula['baseStock'] ?? 2 }}</pre>
        @else
            <pre>Базовый запас для редких товаров = 0</pre>
        @endif

        <label for="">Базовый запас для редких товаров, дополнительное условие</label>
        <pre>Если "Цена Маркеты с теста" больше "Базовый запас для редких товаров стоимостью выше 50 000 (Цена)" тогда "Базовый запас для редких товаров" будет равен "Базовый запас для редких товаров стоимостью выше 50 000 (Значение)"</pre>
        <pre>{{$product->prices->where('name', 'Цена Маркеты с теста')->value('value')}} > {{$salesFormula['baseStockPrice']}} = ({{($salesFormula['baseStockPrice'] > $product->prices->where('name', 'Цена Маркеты с теста')->value('value')) ? "true" : "false"}})</pre>
        @if ($salesFormula['baseStockPrice'] > $product->prices->where('name', 'Цена Маркеты с теста')->value('value'))
            <pre>Базовый запас для редких товаров = {{ $salesFormula['baseStockOverprice'] }}</pre>
        @else
            <pre>Базовый запас для редких товаров = {{ $salesFormula['baseStock'] }}</pre>
        @endif

        <label for="">Базовый запас для редких товаров стоимостью выше 50 000 (Цена)</label>
        <pre>Если есть настройка "Базовый запас для редких товаров стоимостью выше 50 000 (Цена)" тогда будет ее значение, иначе 50000</pre>

        <label for="">Базовый запас для редких товаров стоимостью выше 50 000 (Значение)</label>
        <pre>Если есть настройка "Базовый запас для редких товаров стоимостью выше 50 000 (Значение)" тогда будет ее значение, иначе 1</pre>

        <label>Неснижаемый остаток - ({{ $salesFormula['last_sell_sum'] }} * {{ $salesFormula['replenishmentCoefficient'] }}) + ({{ $salesFormula['unavailable_days_count'] }} * {{ $salesFormula['middleSupply'] }}) + {{ $salesFormula['baseStock'] }} = {{ round(($salesFormula['last_sell_sum'] * $salesFormula['replenishmentCoefficient']) + ($salesFormula['unavailable_days_count'] * $salesFormula['middleSupply']) + $salesFormula['baseStock']) }}</label>
        <pre>(Продажи за 30 дней * Коэффициент пополнения) + (Дней отсутствия за 30 дней * Средний спрос) + Базовый запас для редких товаров = Неснижаемый остаток</pre>

        @if ($salesFormula['maxMinimumBalance'])
            <label>Коэффициент максимального изменения предлагаемого остатка</label>
            <pre>{{$product->minimumBalance}} * {{$salesFormula['maxMinimumBalance']}} = {{ $product->minimumBalance * $salesFormula['maxMinimumBalance'] }}</pre>
        @endif

        @if ($salesFormula['multiplicity'])
            <label>Кратность товара - {{ $salesFormula['multiplicity'] }}</label>
            <pre>Неснижаемый остаток - {{ $salesFormula['minimumBalanceBeforeMultiplicity'] }}</pre>
            @if (empty($salesFormula['sizePackPercent']))
                <pre>"Неснижаемый остаток" < "Кратность товара"</pre>
                <pre>"Неснижаемый остаток" = "Кратность товара" ({{ $salesFormula['multiplicity'] }})</pre>
            @else
                <pre>Процент от упаковки {{ $salesFormula['sizePackPercent'] }}</pre>

                @if ($salesFormula['sizePackPercent'] > 80)
                    <pre>больше 80, округляем в большую сторону - {{ $salesFormula['minimumBalance'] }}</pre>
                @else
                    <pre>меньше 80, округляем в меньшею сторону - {{ $salesFormula['minimumBalance'] }}</pre>
                @endif
            @endif
        @endif
    </div>
    <!-- /.card-body -->
</div>
