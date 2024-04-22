<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employee = Employee::all();

        return view('employee.index', compact('employee'));
    }

    public function json()
    {
        return Employee::all();
    }
}
