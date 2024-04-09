<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingController;

Route::get('/settings', [SettingController::class, 'index'])->name('setting.index');
Route::post('/settings', [SettingController::class, 'store'])->name('setting.store');
