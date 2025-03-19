<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateRolesAndPermissionsSeeder extends Seeder
{
    protected $userID = 1;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::firstOrCreate(['name' => 'administrator']);
        $employee = Role::firstOrCreate(['name' => 'employee']);

        $createUser = Permission::firstOrCreate(['name' => 'create user']);
        $editUser = Permission::firstOrCreate(['name' => 'edit user']);
        $deleteUser = Permission::firstOrCreate(['name' => 'delete user']);

        $admin->givePermissionTo([$createUser, $editUser, $deleteUser]);

        $user = User::find($this->userID);

        if ($user) {
            $user->assignRole($admin);
        }
    }
}
