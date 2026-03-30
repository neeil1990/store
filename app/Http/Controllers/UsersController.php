<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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
        $users = User::where('is_archived', $archived)->get();

        return view('users.index', compact('users', 'archived'));
    }

    public function edit(int $id)
    {
        $user = User::findOrFail($id);

        $roles = Role::all()->pluck('name');

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $data = array_filter($request->all());

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        $validated = $validator->validated();
        $validated['is_archived'] = $request->boolean('is_archived');

        $user->update($validated);

        $user->syncRoles($data['role']);

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
