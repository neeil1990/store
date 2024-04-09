<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TokenController;

Route::post('/token', [TokenController::class, 'create'])->name('token.create');
