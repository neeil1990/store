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

Route::get('session', function () {
    // session()->put('cnt', 222);
    // session()->save();
});

Route::get('dev', function () {

    // https://api.moysklad.ru/api/remap/1.2/entity/product/7944ef04-f831-11e5-7a69-971500188b19

    $api = new \App\Lib\Moysklad\MojSkladJsonApi;
    $api->send('https://api.moysklad.ru/api/remap/1.2/report/stock/bystore/current?stockType=freeStock');
    $rows = $api;

    dd($rows->getRows(), $rows->getErrors());

    // $stock = new MyStoreStock();
    // $rows = $stock;

    // dd($rows->getRows()[0]);
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
});

require __DIR__.'/uri/auth.php';
