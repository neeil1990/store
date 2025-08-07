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
use Illuminate\Support\Facades\Route;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;

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

Route::get('info', function () {
    phpinfo();
});

Route::get('get-product', function () {
    //
});

Route::get('dev', function () {
    $repository = new EloquentShipperRepository();

    $shipper = $repository->getShipperById(1880);

    $facade = new \App\Domain\Shipper\ShipperFacade($shipper);

    $shipper = $facade->getShipperWithWarehouses();

    // dd($shipper->totalPurchaseByWarehouses());
});

Route::get('/profit/{id}/days/{day}', function ($id = 28291, $day = 90) {

    $start = microtime(true);

    $product = Products::find($id);

    $profit = new \App\Services\ProductProfitService();

    $totalSell = [];

    foreach ([3, 5, 7, 15, 30, 60, 90, 180, 365] as $day) {
        $totalSell[$day] = $profit->getTotalSell($product->uuid, Carbon::now()->subDay($day)->toDateTimeString());
    }

    $end = microtime(true);

    dd($totalSell, $end - $start);

    dd('done');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    require __DIR__.'/uri/profile.php';
    require __DIR__.'/uri/users.php';
    require __DIR__.'/uri/settings.php';
    require __DIR__.'/uri/token.php';
    require __DIR__.'/uri/products.php';
    require __DIR__.'/uri/employee.php';
    require __DIR__.'/uri/suppliers.php';
    require __DIR__.'/uri/filters.php';
    require __DIR__.'/uri/shipper.php';
});

require __DIR__.'/uri/auth.php';
