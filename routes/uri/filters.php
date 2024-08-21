<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\FiltersController;

Route::resource('filters', FiltersController::class)->only([
    'store', 'index', 'update', 'destroy'
]);
