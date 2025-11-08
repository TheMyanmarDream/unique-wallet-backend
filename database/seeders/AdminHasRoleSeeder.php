<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Role;

class AdminHasRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get the first admin and first role
        $admin = Admin::first();
        $role = Role::first();
        
        if ($admin && $role) {
            // Attach role to admin using the relationship
            $admin->roles()->attach($role->id);
        }
    }
}
