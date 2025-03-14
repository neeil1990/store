<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

Route::get('users', [UsersController::class, 'index'])->name('users.index');
Route::delete('users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');

