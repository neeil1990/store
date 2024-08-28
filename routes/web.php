<?php

use App\Http\Controllers\ProfileController;
use App\Lib\Moysklad\Receive\MyStoreStock;
use App\Lib\Sale\Store\StoreProductToDataBase;
use App\Lib\Sale\SyncMyStoreWithDataBase;
use App\Models\Products;
use Illuminate\Support\Facades\Route;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\DB;

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

Route::get('curl', function () {
    //
});

Route::get('dev', function () {
    // 7d2031b8-d467-11e8-9ff4-31500038ce02
    // https://online.moysklad.ru/app/#good/edit?id=7d202835-d467-11e8-9ff4-31500038ce00

    $api = new \App\Lib\Moysklad\MojSkladJsonApi;
    $api->send('https://api.moysklad.ru/api/remap/1.2/report/stock/bystore/current?stockType=reserve&filter=assortmentId=b2b393e2-d466-11e8-9ff4-315000386e13');
    $rows = $api->getRows();

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
});

require __DIR__.'/uri/auth.php';
