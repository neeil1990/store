<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;

Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
Route::get('/products/json', [ProductsController::class, 'json'])->name('products.json');
