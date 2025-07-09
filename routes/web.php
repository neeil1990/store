<?php

use App\Http\Controllers\ProfileController;
use App\Infrastructure\EloquentShipperRepository;
use App\Lib\Moysklad\Receive\MyStoreStock;
use App\Lib\Sale\Store\StoreProductToDataBase;
use App\Lib\Sale\SyncMyStoreWithDataBase;
use App\Models\Products;
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

Route::get('get-product', function () {

    $api = new \App\Lib\Moysklad\MojSkladJsonApi;
    $api->send('https://api.moysklad.ru/api/remap/1.2/entity/product?filter=minimumBalance!=0;');
    $rows = $api->getRows();

    dd($rows[1]);
});

Route::get('dev', function () {
    $repository = new EloquentShipperRepository();

    $shipper = $repository->getShipperById(1880);

    $facade = new \App\Domain\Shipper\ShipperFacade($shipper);

    $shipper = $facade->getShipperWithWarehouses();

    // dd($shipper->totalPurchaseByWarehouses());
});

Route::get('/profit/{id}/days/{day}', function ($id = 28291, $day = 90) {

    $bundle = new BundleService();

    $profit = new \App\Services\ProductProfitService();

    $product = Products::find($id);

    dump('-- Товар --');

    $sell = $profit->getProfitByProduct($product->uuid, Carbon::now()->subDay($day)->toDateTimeString());

    if ($sell) {
        dump($product->name, $sell[0]['sellQuantity']);
    }

    dump('-- Комплекты --');

    $bundles = $bundle->getBundleByProduct($product->uuid);

    foreach ($bundles as $bundle) {
        $sell = $profit->getProfitByProduct($bundle['id'], Carbon::now()->subDay($day)->toDateTimeString());

        if ($sell) {
            dump($bundle['name'], $sell[0]['sellQuantity']);
        }
    }

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
