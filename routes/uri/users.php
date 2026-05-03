<?php

use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/users/list-v2', [UsersController::class, 'listV2'])->name('users.listV2');
Route::get('/users/json', [UsersController::class, 'json'])->name('users.json');

Route::resource('users', UsersController::class)->only([
    'index', 'edit', 'update', 'destroy',
]);
