<?php

use App\Http\Controllers\ShipperController;
use Illuminate\Support\Facades\Route;

Route::patch('/shipper/warehouses', [ShipperController::class, 'bulkUpdateWarehouse'])->name('shipper.bulkUpdateWarehouse');
Route::patch('/shipper/{field}', [ShipperController::class, 'bulkUpdate'])->name('shipper.bulkUpdate');

Route::get('/shipper/list-v2', [ShipperController::class, 'listV2'])->name('shipper.listV2');
Route::get('/shipper/json', [ShipperController::class, 'json'])->name('shipper.json');

Route::resource('shipper', ShipperController::class)->only([
    'index', 'edit', 'update',
]);
