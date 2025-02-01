<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        $users = User::all();

        return view('admin.roles-editor', compact('roles', 'permissions', 'users'));
    }

    // Assign Permissions to Roles
    public function assignPermissionToRole(Request $request)
    {
        $request->validate([
            'permission' => 'required|exists:permissions,name',
            'role_id' => 'required|exists:roles,id',
        ]);

        $role = Role::findOrFail($request->role_id);
        $role->givePermissionTo($request->permission);

        return redirect()->back()
            ->with('success', 'Permission assigned to role successfully.');
    }

    // Revoke Permissions from Roles
    public function revokePermissionFromRole(Request $request)
    {
        $request->validate([
            'permission' => 'required|exists:permissions,name',
            'role_id' => 'required|exists:roles,id',
        ]);

        $role = Role::findOrFail($request->role_id);
        $role->revokePermissionTo($request->permission);

        return redirect()->back()
            ->with('success', 'Permission revoked from role successfully.');
    }

    // Assign a Role to a User
    public function store(Request $request)
    {
        $request->validate([
            'user' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($request->input('user'));
        $role = Role::findByName($request->input('role'), 'web');

        if ($user->email_verified_at === null) {
            return redirect()->back()
                ->with('warning', 'This user is not verified yet.');
        }

        if ($user->hasRole('Administrator')) {
            if ($role->name === 'Superuser') {
                return redirect()->back()
                    ->with('warning', 'Administrator cannot assign users to Superuser.');
            }
        }
        if ($user->hasRole('Superuser')) {
            if ($role->name === 'Superuser') {
                return redirect()->back()
                    ->with('warning', 'Superuser cannot assign users to Superuser.');
            }
        }

        if ($user->hasRole($role)) {
            return redirect()->back()
                ->with('warning', 'This role is already assigned to the user.');
        }

        $user->syncRoles($role);

        return redirect()->back()
            ->with('success', 'Role assigned to user successfully.');
    }

    // Remove a Role from a User
    public function destroy(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($request->user_id);
        $role = Role::findByName($request->input('role'), 'web');

        if (auth()->user()->hasRole('Superuser')) {
            if ($role->name === 'Superuser') {
                return redirect()->back()
                    ->with('warning', 'Superusers cannot remove the Superuser role.');
            }

            if ($role->name === 'Administrator') {
                if (!$user->hasRole($role)) {
                    return redirect()->back()
                        ->with('warning', 'This role is not assigned to the user.');
                }

                $user->removeRole($role);

                return redirect()->back()
                    ->with('success', 'Role removed from user successfully.');
            }
        }

        if (auth()->user()->hasRole('Administrator')) {
            if ($role->name === 'Administrator' || $role->name === 'Superuser') {
                return redirect()->back()
                    ->with('warning', 'Administrators cannot remove Administrator or Superuser roles.');
            }
        }

        if (!$user->hasRole($role)) {
            return redirect()->back()
                ->with('warning', 'This role is not assigned to the user.');
        }

        $user->removeRole($role);

        return redirect()->back()
            ->with('success', 'Role removed from user successfully.');
    }
}
