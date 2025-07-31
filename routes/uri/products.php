<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;

Route::get('/products/out-of-stock', [ProductsController::class, 'outOfStock'])->name('products.outOfStock');
Route::post('/products/destroy-stock-totals', [ProductsController::class, 'destroyStockTotals'])->name('products.destroyStockTotals');

Route::get('/products/json', [ProductsController::class, 'json'])->name('products.json');

Route::post('/products/minimum-balance-lager-store', [ProductsController::class, 'minimumBalanceLagerStore'])->name('products.minimum-balance-lager-store');

Route::resource('products', ProductsController::class)->only([
    'index', 'show'
]);
