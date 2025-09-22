<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShipperController;

Route::patch('/shipper/warehouses', [ShipperController::class, 'bulkUpdateWarehouse'])->name('shipper.bulkUpdateWarehouse');
Route::patch('/shipper/{field}', [ShipperController::class, 'bulkUpdate'])->name('shipper.bulkUpdate');

Route::get('/shipper/json', [ShipperController::class, 'json'])->name('shipper.json');

Route::resource('shipper', ShipperController::class)->only([
    'index', 'edit', 'update'
]);
