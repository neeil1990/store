<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;

Route::get('/products/json', [ProductsController::class, 'json'])->name('products.json');
Route::resource('products', ProductsController::class)->only([
    'index', 'show'
]);
