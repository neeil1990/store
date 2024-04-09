<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Ixudra\Curl\Facades\Curl;

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

Route::get('dev', function () {

    /*
     $token = (new \App\Lib\Moysklad\Authorization)
        ->setLogin('nk@almamed')
        ->setPassword('@_7_tLJGJJ6GXAL')
        ->token();

    dd($token);
    */

    $response = (new \App\Lib\Moysklad\RequestStore())
        ->send('https://api.moysklad.ru/api/remap/1.2/entity/product')
        ->getResponse();

    dd($response->rows[0]);
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    require __DIR__.'/uri/profile.php';
    require __DIR__.'/uri/users.php';
    require __DIR__.'/uri/settings.php';
    require __DIR__.'/uri/token.php';
});

require __DIR__.'/uri/auth.php';
