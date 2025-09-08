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
        </ul>

        <label>Неснижаемый остаток</label><br>
        <pre>(Продажи за 30 дней * Коэффициент пополнения) + (Дней отсутствия за 30 дней * Средний спрос) + Базовый запас для редких товаров = Неснижаемый остаток</pre>
        <pre>({{ $salesFormula['last_sell_sum'] }} * {{ $salesFormula['replenishmentCoefficient'] }}) + ({{ $salesFormula['unavailable_days_count'] }} * {{ $salesFormula['middleSupply'] }}) + {{ $salesFormula['baseStock'] }} = {{ $salesFormula['minimumBalance'] }}</pre>

    </div>
    <!-- /.card-body -->
</div>
