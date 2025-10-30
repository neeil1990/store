<?php

use App\Http\Controllers\ProfileController;
use App\Infrastructure\EloquentShipperRepository;
use App\Lib\Moysklad\Receive\MyStoreBundle;
use App\Lib\Moysklad\Receive\MyStoreStock;
use App\Lib\Moysklad\Receive\MyStoreStockTotal;
use App\Lib\Sale\Store\StoreProductToDataBase;
use App\Lib\Sale\Store\StoreStockToDataBase;
use App\Lib\Sale\SyncMyStoreWithDataBase;
use App\Models\Products;
use App\Models\StockTotal;
use App\Models\User;
use App\Services\BundleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;
use App\Services\ProductProfitService;
use App\Models\Sell;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/get-sales/{id}', function ($id, Request $request) {

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
        'product' => $product,
        'bundles' => $bundles,
        'saleProducts' => $saleProducts,
        'saleBundles' => $saleBundles,
        'dates' => $dates,
        'result' => $result,
    ]);
})->name('get-sales-test');

Route::get('info', function () {
    phpinfo();
});

Route::get('dev', function () {
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
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    require __DIR__ . '/uri/profile.php';
    require __DIR__ . '/uri/users.php';
    require __DIR__ . '/uri/settings.php';
    require __DIR__ . '/uri/token.php';
    require __DIR__ . '/uri/products.php';
    require __DIR__ . '/uri/employee.php';
    require __DIR__ . '/uri/suppliers.php';
    require __DIR__ . '/uri/filters.php';
    require __DIR__ . '/uri/shipper.php';
});

require __DIR__ . '/uri/auth.php';
