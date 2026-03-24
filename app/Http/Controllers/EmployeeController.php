<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $archived = $request->boolean('archived');
        $employee = Employee::where('archived', $archived)->get();

        return view('employee.index', compact('employee', 'archived'));
    }

    public function json()
    {
        return Employee::all();
    }
}
