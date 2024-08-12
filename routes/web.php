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

    // $api = new \App\Lib\Moysklad\MojSkladJsonApi;
    // $api->send('https://api.moysklad.ru/api/remap/1.2/report/stock/bystore/current?stockType=stock');
    // $rows = $api;

    // SELECT
    // products.*,
    // stocks.stock,
    // transits.transit,
    // reserves.reserve
    // FROM `products`
    // INNER JOIN (SELECT assortmentId, SUM(quantity) stock FROM stocks GROUP BY assortmentId) stocks ON stocks.assortmentId = products.uuid
    // LEFT JOIN (SELECT assortmentId, SUM(quantity) transit FROM transits GROUP BY assortmentId) transits ON transits.assortmentId = products.uuid
    // LEFT JOIN (SELECT assortmentId, SUM(quantity) reserve FROM reserves GROUP BY assortmentId) reserves ON reserves.assortmentId = products.uuid
    // WHERE minimumBalance - stocks.stock > 0
    // ORDER BY `transits`.`transit` DESC;

    $stocks = new \App\Models\Stock();
    $stock = $stocks->select('assortmentId', DB::raw('SUM(quantity) stock'))->groupBy('assortmentId');

    $reserves = new \App\Models\Reserve();
    $reserve = $reserves->select('assortmentId', DB::raw('SUM(quantity) reserve'))->groupBy('assortmentId');

    $transits = new \App\Models\Transit();
    $transit = $transits->select('assortmentId', DB::raw('SUM(quantity) transit'))->groupBy('assortmentId');

    $model = (new Products())
        ->joinSub($stock, 'stocks', function($join){
            $join->on('products.uuid', '=', 'stocks.assortmentId');
        })
        ->leftJoinSub($reserve, 'reserves', function($join){
            $join->on('products.uuid', '=', 'reserves.assortmentId');
        })
        ->leftJoinSub($transit, 'transits', function($join){
            $join->on('products.uuid', '=', 'transits.assortmentId');
        })
        ->whereRaw('minimumBalance - stock > ?', [0]);

    dd($model->first());
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
