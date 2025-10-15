<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Create or get roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $viewerRole = Role::firstOrCreate(['name' => 'viewer']);

        // Create or get permissions
        $deleteUserSheetPermission = Permission::firstOrCreate(['name' => 'admin user sheet']);
        $updateUserSheetPermission = Permission::firstOrCreate(['name' => 'update user sheet']);
        $viewUserSheetPermission = Permission::firstOrCreate(['name' => 'view user sheet']);

        // Assign permissions to roles
        $adminRole->givePermissionTo($deleteUserSheetPermission);
        $adminRole->givePermissionTo($updateUserSheetPermission);
        $adminRole->givePermissionTo($viewUserSheetPermission);

        $editorRole->givePermissionTo($updateUserSheetPermission);
        $editorRole->givePermissionTo($viewUserSheetPermission);

        $viewerRole->givePermissionTo($viewUserSheetPermission);
    }
}
