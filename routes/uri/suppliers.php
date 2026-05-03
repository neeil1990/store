<?php

use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/suppliers/list-v2', [SupplierController::class, 'listV2'])->name('suppliers.listV2');
Route::get('/suppliers/json', [SupplierController::class, 'json'])->name('suppliers.json');
Route::resource('suppliers', SupplierController::class)->only([
    'index', 'show',
]);
