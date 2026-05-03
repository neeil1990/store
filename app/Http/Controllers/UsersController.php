<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:edit user')->only('edit');
        $this->middleware('can:delete user')->only('destroy');
    }

    public function index(Request $request)
    {
        $archived = $request->boolean('archived');
        $users = User::query()
            ->select(['id', 'name', 'email', 'department', 'is_archived', 'created_at', 'phone'])
            ->where('is_archived', $archived)
            ->with('roles')
            ->orderBy('id')
            ->paginate(50)
            ->withQueryString();

        return view('users.index', compact('users', 'archived'));
    }

    public function edit(int $id)
    {
        $user = User::findOrFail($id);

        $roles = Role::query()
            ->where('guard_name', $user->getGuardName())
            ->orderBy('name')
            ->pluck('name');

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->only(['name', 'department', 'email', 'phone', 'role']);

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'role' => [
                'required',
                'string',
                Rule::exists('roles', 'name')->where('guard_name', $user->getGuardName()),
            ],
        ]);

        $validated = $validator->validated();
        $validated['is_archived'] = $request->boolean('is_archived');

        $role = $validated['role'];
        unset($validated['role']);

        $user->update($validated);
        $user->syncRoles($role);

        return redirect()->route('users.index');
    }

    public function destroy(int $id): RedirectResponse
    {
        if (Auth::id() !== $id) {
            User::destroy($id);
        }

        return redirect()->route('users.index');
    }
}
