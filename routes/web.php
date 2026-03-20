<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    require __DIR__ . '/uri/profile.php';
    require __DIR__ . '/uri/users.php';
    require __DIR__ . '/uri/settings.php';
    require __DIR__ . '/uri/token.php';
    require __DIR__ . '/uri/products.php';
    require __DIR__ . '/uri/employee.php';
    require __DIR__ . '/uri/suppliers.php';
    require __DIR__ . '/uri/filters.php';
    require __DIR__ . '/uri/shipper.php';
});

require __DIR__ . '/uri/auth.php';

// Dev/test маршруты (закомментируйте для отключения)
require __DIR__ . '/uri/dev.php';

