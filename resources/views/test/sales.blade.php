<h1>Товар</h1>

<table border="1" cellpadding="10" cellspacing="5">
    <tr>
        <th>UUID</th>
        <th>Название товара или комплекта</th>
        <th>Артикул</th>
        <th>ед. измерения</th>
    </tr>

    <tr>
        <td>{{ $product->uuid }}</td>
        <td>{{ $product->name }}</td>
        <td>{{ $product->article }}</td>
        <td>{{ $product->uoms->name }}</td>
    </tr>
</table>

<h1>Комплекты товара</h1>

<table border="1" cellpadding="10" cellspacing="5">
    <tr>
        <th>UUID</th>
        <th>Название товара или комплекта</th>
        <th>Артикул</th>
    </tr>

    @foreach ($bundles as $bundle)
        <tr>
            <td>{{ $bundle['uuid'] }}</td>
            <td>{{ $bundle['name'] }}</td>
            <td>{{ $bundle['article'] }}</td>
        </tr>
    @endforeach

</table>

<h1>Запрос отчета прибыльность.</h1>

<label for="">Укажите количество дней.</label>
<form action="">
    <input type="number" name="sub_day" value="{{ request('sub_day') }}">
    <input type="submit" value="Отправить">
</form>

<h2>Период - {{ $dates }}</h2>

<h1>Продажи по товару.</h1>

<table border="1" cellpadding="10" cellspacing="5">
    <tr>
        <th>Название товара или комплекта</th>
        <th>sellQuantity - Проданное количество</th>
        <th>sellPrice - Цена продаж (средняя)</th>
        <th>sellCost - Себестоимость в копейках</th>
        <th>sellSum - Сумма продаж</th>
        <th>sellCostSum - Сумма себестоимостей продаж в копейках</th>
        <th>returnQuantity - Возвращенное количество</th>
        <th>returnPrice - Цена возвратов</th>
        <th>returnCost - Себестоимость возвратов в копейках</th>
        <th>returnSum - Сумма возвратов</th>
        <th>returnCostSum - Сумма себестоимостей возвратов в копейках</th>
        <th>profit - Прибыль</th>
        <th>margin - Рентабельность товара</th>
        <th>salesMargin - Рентабельность продаж</th>
    </tr>

    @foreach ($saleProducts as $sale)
        <tr>
            <td>{{ $sale['assortment']['name'] }}, {{ $sale['assortment']['article'] }}</td>
            <td style="background-color: rgba(14,91,68,0.57)">{{ $sale['sellQuantity'] }}</td>
            <td>{{ $sale['sellPrice'] }}</td>
            <td>{{ $sale['sellCost'] }}</td>
            <td>{{ $sale['sellSum'] }}</td>
            <td>{{ $sale['sellCostSum'] }}</td>
            <td>{{ $sale['returnQuantity'] }}</td>
            <td>{{ $sale['returnPrice'] }}</td>
            <td>{{ $sale['returnCost'] }}</td>
            <td>{{ $sale['returnSum'] }}</td>
            <td>{{ $sale['returnCostSum'] }}</td>
            <td>{{ $sale['profit'] }}</td>
            <td>{{ $sale['margin'] }}</td>
            <td>{{ $sale['salesMargin'] }}</td>
        </tr>
    @endforeach

</table>

<h1>Продажи комплектов в которых есть товар.</h1>

<table border="1" cellpadding="10" cellspacing="5">
    <tr>
        <th>Название товара или комплекта</th>
        <th>sellQuantity - Проданное количество</th>
        <th>sellPrice - Цена продаж (средняя)</th>
        <th>sellCost - Себестоимость в копейках</th>
        <th>sellSum - Сумма продаж</th>
        <th>sellCostSum - Сумма себестоимостей продаж в копейках</th>
        <th>returnQuantity - Возвращенное количество</th>
        <th>returnPrice - Цена возвратов</th>
        <th>returnCost - Себестоимость возвратов в копейках</th>
        <th>returnSum - Сумма возвратов</th>
        <th>returnCostSum - Сумма себестоимостей возвратов в копейках</th>
        <th>profit - Прибыль</th>
        <th>margin - Рентабельность товара</th>
        <th>salesMargin - Рентабельность продаж</th>
    </tr>

    @foreach ($saleBundles as $sale)
        <tr>
            <td>{{ $sale['assortment']['name'] }}, {{ $sale['assortment']['article'] }}</td>
            <td style="background-color: rgba(14,91,68,0.57)">{{ $sale['sellQuantity'] }}</td>
            <td>{{ $sale['sellPrice'] }}</td>
            <td>{{ $sale['sellCost'] }}</td>
            <td>{{ $sale['sellSum'] }}</td>
            <td>{{ $sale['sellCostSum'] }}</td>
            <td>{{ $sale['returnQuantity'] }}</td>
            <td>{{ $sale['returnPrice'] }}</td>
            <td>{{ $sale['returnCost'] }}</td>
            <td>{{ $sale['returnSum'] }}</td>
            <td>{{ $sale['returnCostSum'] }}</td>
            <td>{{ $sale['profit'] }}</td>
            <td>{{ $sale['margin'] }}</td>
            <td>{{ $sale['salesMargin'] }}</td>
        </tr>
    @endforeach

</table>

<h1>Данные которые будут сохранены: {{ $result }}</h1>



