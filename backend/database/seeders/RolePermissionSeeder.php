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

        // ============================================================
        // 1. DAFTAR PERMISSION (berdasarkan modul di PRD)
        // ============================================================
        $permissions = [
            // User & Auth
            'manage_users',
            'manage_roles',
            'manage_permissions',

            // Branch
            'manage_branches',

            // Product & Catalog
            'manage_products',
            'manage_categories',
            'manage_brands',

            // Inventory
            'manage_inventory',
            'manage_inventory_transfers',

            // Rental
            'manage_rentals',
            'manage_bookings',

            // Laundry
            'manage_laundry',

            // POS
            'manage_pos',

            // Customer
            'manage_customers',

            // Finance
            'manage_payments',
            'manage_invoices',
            'manage_expenses',

            // Reports
            'view_reports',
            'export_reports',

            // Settings
            'manage_settings',

            // Promotions
            'manage_promotions',
            'manage_vouchers',

            // CMS
            'manage_cms_pages',
            'manage_cms_banners',
            'manage_cms_blogs',
            'manage_faqs',

            // Audit
            'view_audit_logs',

            // All (untuk super admin)
            'manage_all',
        ];

        // Buat permission satu per satu
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // ============================================================
        // 2. DAFTAR ROLE
        // ============================================================
        $roles = [
            'super_admin' => Permission::all()->pluck('name')->toArray(),
            'admin' => [
                'manage_users',
                'manage_branches',
                'manage_products',
                'manage_categories',
                'manage_brands',
                'manage_inventory',
                'manage_inventory_transfers',
                'manage_rentals',
                'manage_bookings',
                'manage_laundry',
                'manage_pos',
                'manage_customers',
                'manage_payments',
                'manage_invoices',
                'manage_expenses',
                'view_reports',
                'export_reports',
                'manage_settings',
                'manage_promotions',
                'manage_vouchers',
                'manage_cms_pages',
                'manage_cms_banners',
                'manage_cms_blogs',
                'manage_faqs',
                'view_audit_logs',
            ],
            'manager' => [
                'manage_products',
                'manage_categories',
                'manage_brands',
                'manage_inventory',
                'manage_rentals',
                'manage_bookings',
                'manage_laundry',
                'manage_pos',
                'manage_customers',
                'manage_payments',
                'manage_invoices',
                'view_reports',
                'manage_promotions',
                'manage_vouchers',
            ],
            'staff' => [
                'manage_rentals',
                'manage_bookings',
                'manage_laundry',
                'manage_pos',
                'manage_customers',
                'manage_payments',
            ],
            'cashier' => [
                'manage_pos',
                'manage_payments',
                'manage_customers',
            ],
            'warehouse_staff' => [
                'manage_inventory',
                'manage_inventory_transfers',
                'manage_products',
                'manage_categories',
                'manage_brands',
            ],
        ];

        foreach ($roles as $roleName => $permissionList) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $role->syncPermissions($permissionList);
        }

        // ============================================================
        // 3. ASSIGN ROLE KE USER SUPER ADMIN (ID 1)
        // ============================================================
        $user = \App\Models\User::find(1);
        if ($user) {
            $user->assignRole('super_admin');
        }

        $this->command->info('✅ All permissions and roles seeded successfully!');
    }
}