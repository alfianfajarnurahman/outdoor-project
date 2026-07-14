<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat permissions
        Permission::create(['name' => 'manage_users']);
        Permission::create(['name' => 'manage_products']);
        Permission::create(['name' => 'manage_inventory']);
        Permission::create(['name' => 'manage_rentals']);
        Permission::create(['name' => 'manage_laundry']);
        Permission::create(['name' => 'manage_pos']);
        Permission::create(['name' => 'manage_reports']);
        Permission::create(['name' => 'manage_settings']);

        // Buat roles
        $superAdmin = Role::create(['name' => 'super_admin']);
        $admin = Role::create(['name' => 'admin']);
        $manager = Role::create(['name' => 'manager']);
        $staff = Role::create(['name' => 'staff']);

        // Assign permissions ke roles
        $superAdmin->givePermissionTo(Permission::all());
        $admin->givePermissionTo(['manage_users', 'manage_products', 'manage_inventory', 'manage_rentals', 'manage_laundry', 'manage_pos', 'manage_reports']);
        $manager->givePermissionTo(['manage_products', 'manage_inventory', 'manage_rentals', 'manage_laundry', 'manage_pos']);
        $staff->givePermissionTo(['manage_rentals', 'manage_laundry']);
    }
}