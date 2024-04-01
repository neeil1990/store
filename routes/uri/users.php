<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

Route::get('/users', [UsersController::class, 'index'])->name('users.index');

