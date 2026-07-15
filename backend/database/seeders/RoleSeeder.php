<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ============================================================
        // 1. DAFTAR ROLE
        // ============================================================
        $roles = [
            'super_admin' => [
                'description' => 'Akses penuh ke seluruh sistem',
                'permissions' => Permission::all()->pluck('name')->toArray(),
            ],
            'owner' => [
                'description' => 'Pemilik bisnis, bisa melihat semua cabang dan laporan',
                'permissions' => [
                    'manage_branches',
                    'manage_products',
                    'manage_categories',
                    'manage_brands',
                    'manage_inventory',
                    'view_reports',
                    'export_reports',
                    'manage_settings',
                    'manage_promotions',
                    'manage_vouchers',
                    'view_audit_logs',
                    'manage_users',
                ],
            ],
            'manager' => [
                'description' => 'Manajer cabang, mengelola operasional sehari-hari',
                'permissions' => [
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
                    'view_reports',
                    'manage_promotions',
                    'manage_vouchers',
                ],
            ],
            'staff' => [
                'description' => 'Staf operasional, melayani rental, laundry, dan POS',
                'permissions' => [
                    'manage_rentals',
                    'manage_bookings',
                    'manage_laundry',
                    'manage_pos',
                    'manage_customers',
                    'manage_payments',
                ],
            ],
        ];

        foreach ($roles as $roleName => $data) {
            $role = Role::firstOrCreate(
                ['name' => $roleName, 'guard_name' => 'web']
            );

            // Assign description secara terpisah (jika kolom sudah ada)
            $role->description = $data['description'];
            $role->save();

            // Assign permissions ke role
            $role->syncPermissions($data['permissions']);
        }

        // ============================================================
        // 2. ASSIGN ROLE KE USER SUPER ADMIN (ID 1)
        // ============================================================
        $user = \App\Models\User::find(1);
        if ($user) {
            $user->assignRole('super_admin');
        }

        $this->command->info('✅ Roles seeded successfully!');
        $this->command->info('📋 Roles: super_admin, owner, manager, staff');
    }
}