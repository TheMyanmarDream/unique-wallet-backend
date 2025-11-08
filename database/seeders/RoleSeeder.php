<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $superAdminRole = Role::create([
            'name' => 'Super Admin',
        ]);

        $adminRole = Role::create([
            'name' => 'Admin',
        ]);

        $moderatorRole = Role::create([
            'name' => 'Moderator',
        ]);

        // Create default super admin
        $superAdmin = Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        // Assign super admin role
        $superAdmin->roles()->attach($superAdminRole);
    }
}
