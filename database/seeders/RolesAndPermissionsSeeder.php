<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        if (! class_exists(\Spatie\Permission\Models\Role::class) || ! class_exists(\Spatie\Permission\Models\Permission::class)) {
            return;
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view-course',
            'create-course',
            'edit-course',
            'delete-course',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::findOrCreate($permission, 'admin');
            \Spatie\Permission\Models\Permission::findOrCreate($permission, 'web');
        }

        $superAdmin = \Spatie\Permission\Models\Role::findOrCreate('Super Admin', 'admin');
        $admin = \Spatie\Permission\Models\Role::findOrCreate('Admin', 'admin');
        $teacher = \Spatie\Permission\Models\Role::findOrCreate('Teacher', 'web');
        $student = \Spatie\Permission\Models\Role::findOrCreate('Student', 'web');

        $superAdmin->givePermissionTo($permissions);
        $admin->givePermissionTo(['view-course', 'create-course', 'edit-course']);
        $teacher->givePermissionTo(['view-course']);
        $student->givePermissionTo(['view-course']);
    }
}
