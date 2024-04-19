<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

Route::get('/employee/json', [EmployeeController::class, 'json'])->name('employee.json');
