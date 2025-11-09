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

        $managerRole = Role::create([
            'name' => 'Manager',
        ]);

        $staffRole = Role::create([
            'name' => 'Staff',
        ]);

        $financeManagerRole = Role::create([
            'name' => 'Finance Manager',
        ]);
    }
}
