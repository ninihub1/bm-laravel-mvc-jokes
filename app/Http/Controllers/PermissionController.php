<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::paginate(10);
        $roles = Role::with('permissions')->paginate(10);

        return view('roles-permissions.index', compact(['permissions'], ['roles']));
    }

    public function create()
    {
        return view('roles-permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);

        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        return redirect()->route('roles-permissions.index')
                         ->with('success', 'Permission created successfully.');
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);

        return view('roles-permissions.update', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $id,
        ]);

        $permission = Permission::findOrFail($id);

        $permission->update([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        return redirect()->route('roles-permissions.index')
                         ->with('success', 'Permission updated successfully.');
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

        $permission->delete();

        return redirect()->route('roles-permissions.index')
                         ->with('success', 'Permission deleted successfully.');
    }
}
