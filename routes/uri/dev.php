<?php

use App\Lib\Moysklad\Receive\MyStoreStock;
use App\Lib\Moysklad\Receive\MyStoreStockTotal;
use App\Lib\Sale\SyncMyStoreWithDataBase;
use App\Models\Employee;
use App\Models\Products;
use App\Services\BundleService;
use App\Services\ProductProfitService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Dev / Test Routes
|--------------------------------------------------------------------------
|
| Маршруты для отладки и тестирования.
| Префикс: /dev
| Пример: /dev/info, /dev/stock, /dev/sales/1?sub_day=30
|
| Чтобы отключить все тестовые маршруты — достаточно закомментировать
| require в web.php.
|
*/

Route::prefix('dev')->group(function () {

    // phpinfo
    Route::get('/info', function () {
        phpinfo();
    })->name('dev.info');

    // Проверка остатков из МойСклад (MyStoreStock)
    Route::get('/stock', function () {
        $stocks = (new MyStoreStock())->getRows();

        return response()->json([
            'count' => count($stocks),
            'data'  => $stocks,
        ]);
    })->name('dev.stock');

    // Проверка остатков из МойСклад (MyStoreStockTotal) по конкретному assortmentId
    Route::get('/stock-total', function () {
        $stocks = (new MyStoreStockTotal())->getRows();

        $assortmentId = "7f9afe5e-e1c2-11ec-0a80-0e0f002a2e76";

        dump("https://api.moysklad.ru/api/remap/1.2/report/stock/all/current?include=zeroLines");
        dump("assortmentId - $assortmentId");

        foreach ($stocks as $stock) {
            if ($assortmentId == $stock["assortmentId"]) {
                dump($stock["assortmentId"] . " stock - " . $stock["stock"]);
            }
        }

        dd("done");
    })->name('dev.stock-total');

    // Тест продаж по товару
    Route::get('/sales/{id}', function ($id, Request $request) {
        $subDay = $request->get('sub_day');

        $product = Products::find($id);
        $uuid = $product->uuid;

        $bundles = (new BundleService())->getBundleByProduct($uuid);

        $saleProducts = $saleBundles = [];
        $dates = '';
        $result = 0;

        if ($subDay) {
            $sale = new ProductProfitService();
            $start = Carbon::now()->subDays($subDay);

            $saleProducts = $sale->getProfitByProduct([$uuid], $start);
            $saleBundles = $sale->getProfitByProduct(Arr::pluck($bundles, 'uuid'), $start);
            $result = $sale->getTotalSell($uuid, $start);

            $dates .= $start . ' - ' . Carbon::now();
        }

        return view('test.sales', [
            'product'      => $product,
            'bundles'      => $bundles,
            'saleProducts' => $saleProducts,
            'saleBundles'  => $saleBundles,
            'dates'        => $dates,
            'result'       => $result,
        ]);
    })->name('dev.sales');

    // Синхронизация сотрудников из МойСклад
    Route::get('/employee-sync', function () {
        $beforeCount = Employee::count();
        $beforeArchived = Employee::where('archived', true)->count();

        (new SyncMyStoreWithDataBase())->employeeSync();

        $afterCount = Employee::count();
        $afterArchived = Employee::where('archived', true)->count();

        return response()->json([
            'message'  => 'employeeSync выполнен',
            'before'   => [
                'total'    => $beforeCount,
                'archived' => $beforeArchived,
                'active'   => $beforeCount - $beforeArchived,
            ],
            'after'    => [
                'total'    => $afterCount,
                'archived' => $afterArchived,
                'active'   => $afterCount - $afterArchived,
            ],
        ]);
    })->name('dev.employee-sync');
});
