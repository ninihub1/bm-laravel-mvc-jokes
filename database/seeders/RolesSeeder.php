<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    private $permissions = [
        'joke-browse', 'joke-read', 'joke-add', 'joke-edit', 'joke-delete',
        'user-browse', 'user-read', 'user-register', 'user-add', 'user-edit', 'user-delete',
        'user-login', 'user-logout',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        foreach ($this->permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }

        // Create permissions
        $rolesWithPermissions = [
            'Superuser' => $this->permissions,
            'Administrator' => [
                'joke-browse', 'joke-read', 'joke-add', 'joke-edit', 'joke-delete',
                'user-browse', 'user-read', 'user-register', 'user-add', 'user-edit',
                'user-login', 'user-logout',
            ],
            'Staff' => [
                'joke-browse', 'joke-read', 'joke-add', 'joke-edit', 'joke-delete',
                'user-browse', 'user-read', 'user-login', 'user-logout',
            ],
            'Client' => [
                'joke-browse', 'joke-read', 'joke-add', 'joke-edit', 'joke-delete',
                'user-login', 'user-logout',
            ],
        ];

        foreach ($rolesWithPermissions as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($permissions);
        }
    }
}
