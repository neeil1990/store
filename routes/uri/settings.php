<?php

use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/settings', [SettingController::class, 'index'])->name('setting.index');
Route::post('/settings', [SettingController::class, 'store'])->name('setting.store');
Route::post('/settings/all', [SettingController::class, 'storeAll'])->name('setting.storeAll');
Route::post('/settings/cache', [SettingController::class, 'updateLayoutCache'])->name('setting.updateLayoutCache');
Route::post('/settings/cache/flush', [SettingController::class, 'flushLayoutCache'])->name('setting.flushLayoutCache');
Route::post('/settings/sidebar-menu', [SettingController::class, 'updateSidebarMenu'])->name('setting.updateSidebarMenu');
Route::post('/import', [SettingController::class, 'import'])->name('setting.import');
