<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShipperController;

Route::get('/shipper/json', [ShipperController::class, 'json'])->name('shipper.json');

Route::resource('shipper', ShipperController::class)->only([
    'index', 'edit', 'update'
]);
