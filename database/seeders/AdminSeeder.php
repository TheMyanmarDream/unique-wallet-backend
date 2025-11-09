<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default super admin
        $superAdmin = Admin::firstOrCreate([
            'email' => 'admin@admin.com'
        ], [
            'name' => 'Super Admin',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        // Get super admin role
        $superAdminRole = Role::where('name', 'Super Admin')->first();

        if ($superAdminRole && !$superAdmin->roles->contains($superAdminRole->id)) {
            $superAdmin->roles()->attach($superAdminRole->id);
        }

        // Create additional demo admins
        $admin = Admin::firstOrCreate([
            'email' => 'manager@admin.com'
        ], [
            'name' => 'Brand Manager',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $managerRole = Role::where('name', 'Manager')->first();
        if ($managerRole && !$admin->roles->contains($managerRole->id)) {
            $admin->roles()->attach($managerRole->id);
        }

        // Create finance manager
        $financeAdmin = Admin::firstOrCreate([
            'email' => 'finance@admin.com'
        ], [
            'name' => 'Finance Manager',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $financeRole = Role::where('name', 'Finance Manager')->first();
        if ($financeRole && !$financeAdmin->roles->contains($financeRole->id)) {
            $financeAdmin->roles()->attach($financeRole->id);
        }
    }
}
