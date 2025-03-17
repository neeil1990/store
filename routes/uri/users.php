<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

Route::resource('users', UsersController::class)->only([
    'index', 'edit', 'update', 'destroy'
]);

