<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Товары') }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="products-table" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>article</th>
                <th>name</th>
                <th>externalCode</th>
                <th>pathName</th>
                <th>salePrices</th>
                <th>buyPrice</th>
                <th>minPrice</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product['article'] }}</td>
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $product['externalCode'] }}</td>
                    <td>{{ $product['pathName'] }}</td>
                    <td>{{ $product['salePrices'] }}</td>
                    <td>{{ $product['buyPrice'] }}</td>
                    <td>{{ $product['minPrice'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->


