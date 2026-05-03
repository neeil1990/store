<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');
Route::get('/employee/list-v2', [EmployeeController::class, 'listV2'])->name('employee.listV2');
Route::get('/employee/datatable-json', [EmployeeController::class, 'datatableJson'])->name('employee.datatable.json');
Route::get('/employee/json', [EmployeeController::class, 'json'])->name('employee.json');
