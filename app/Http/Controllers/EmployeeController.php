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
        $employees = Employee::query()
            ->where('archived', $archived)
            ->orderBy('name')
            ->paginate(50)
            ->withQueryString();

        return view('employee.index', compact('employees', 'archived'));
    }

    public function json(): JsonResponse
    {
        if (! DataOutputCache::enabled()) {
            return response()->json($this->employeesJsonRows());
        }

        $identity = DataOutputCache::normalizeForKey([
            '_uid' => Auth::id(),
        ]);
        $rows = DataOutputCache::remember(
            DataOutputCache::REVISION_EMPLOYEES,
            DataOutputCache::SEGMENT_EMPLOYEES_JSON,
            $identity,
            null,
            fn () => $this->employeesJsonRows()
        );

        return response()->json(is_array($rows) ? $rows : []);
    }

    /**
     * @return list<array{id: int, uuid: string, name: string, externalCode: string, email: ?string, fullName: ?string, archived: bool}>
     */
    private function employeesJsonRows(): array
    {
        return Employee::query()
            ->orderBy('name')
            ->get(['id', 'uuid', 'name', 'externalCode', 'email', 'fullName', 'archived'])
            ->map(static fn (Employee $e) => [
                'id' => $e->id,
                'uuid' => $e->uuid,
                'name' => $e->name,
                'externalCode' => $e->externalCode,
                'email' => $e->email,
                'fullName' => $e->fullName,
                'archived' => (bool) $e->archived,
            ])
            ->values()
            ->all();
    }
}
