<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShipperController;

Route::get('/shipper/json', [ShipperController::class, 'json'])->name('shipper.json');
Route::get('/shipper/calculate-fields', [ShipperController::class, 'calculateFields'])->name('shipper.calculate-fields');
Route::get('/shipper/warehouse-stock-all/{supplier_id}', [ShipperController::class, 'warehouseStockAll'])->name('shipper.warehouse-stock-all');
Route::get('/shipper/warehouse-stock-selected/{supplier_id}', [ShipperController::class, 'warehouseStockSelected'])->name('shipper.warehouse-stock-selected');

Route::resource('shipper', ShipperController::class)->only([
    'index', 'edit', 'update'
]);

Route::post('/shipper/min-sum-update', [ShipperController::class, 'minSumUpdate'])->name('shipper.minSumUpdate');
Route::post('/shipper/fill-storage-update', [ShipperController::class, 'fillStorageUpdate'])->name('shipper.fillStorageUpdate');
