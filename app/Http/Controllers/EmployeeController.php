<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Services\DataOutputCache;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $archived = $request->boolean('archived');
        $employee = Employee::where('archived', $archived)->get();

        return view('employee.index', compact('employee', 'archived'));
    }

    public function json(): JsonResponse
    {
        if (! DataOutputCache::enabled()) {
            return response()->json(Employee::all());
        }

        $identity = DataOutputCache::normalizeForKey([
            '_uid' => Auth::id(),
        ]);
        $rows = DataOutputCache::remember(
            DataOutputCache::REVISION_EMPLOYEES,
            DataOutputCache::SEGMENT_EMPLOYEES_JSON,
            $identity,
            null,
            fn () => Employee::all()->map(fn (Employee $e) => $e->toArray())->values()->all()
        );

        return response()->json(is_array($rows) ? $rows : []);
    }
}
