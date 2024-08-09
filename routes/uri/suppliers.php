<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\SupplierController;

Route::get('/suppliers/json', [SupplierController::class, 'json'])->name('suppliers.json');
Route::resource('suppliers', SupplierController::class)->only([
    'index', 'show'
]);
