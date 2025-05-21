<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShipperController;

Route::get('/shipper/json', [ShipperController::class, 'json'])->name('shipper.json');

Route::resource('shipper', ShipperController::class)->only([
    'index', 'edit', 'update'
]);

Route::post('/ajax/min-sum-update', [ShipperController::class, 'minSumUpdate'])->name('shipper.minSumUpdate');
Route::post('/ajax/fill-storage-update', [ShipperController::class, 'fillStorageUpdate'])->name('shipper.fillStorageUpdate');
