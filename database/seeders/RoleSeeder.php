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
            'slug' => 'super-admin',
            'description' => 'Has full access to all features',
        ]);

        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Has access to admin features',
        ]);

        $moderatorRole = Role::create([
            'name' => 'Moderator',
            'slug' => 'moderator',
            'description' => 'Has limited admin access',
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
