<?php

use App\Http\Controllers\DescriptionController;
use Illuminate\Support\Facades\Route;

Route::resource('descriptions', DescriptionController::class);
Route::get('descriptions/key/{key}', [DescriptionController::class, 'showByKey'])->name('descriptions.showByKey');
Route::get('descriptions/json/{key}', [DescriptionController::class, 'jsonByKey'])->name('descriptions.jsonByKey');
