<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;

Route::get('/products/out-of-stock/settings/{key}', [ProductsController::class, 'getOutOfStockSettings'])->name('products.getOutOfStockSettings');
Route::get('/products/out-of-stock', [ProductsController::class, 'outOfStock'])->name('products.outOfStock');
Route::post('/products/destroy-stock-totals', [ProductsController::class, 'destroyStockTotals'])->name('products.destroyStockTotals');
Route::post('/products/out-of-stock', [ProductsController::class, 'storeOutOfStockSettings'])->name('products.storeOutOfStockSettings');

Route::get('/products/json', [ProductsController::class, 'json'])->name('products.json');

// Универсальный маршрут для обновления полей товара
Route::post('/products/update-field', [ProductsController::class, 'updateProductField'])->name('products.update-field');

Route::resource('products', ProductsController::class)->only([
    'index', 'show'
]);
