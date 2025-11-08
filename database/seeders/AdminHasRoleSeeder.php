<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Role;
use App\Models\AdminHasRole;

class AdminHasRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         AdminHasRole::create([
            'admin_id' => 1,
            'role_id' => 1
        ]);
    }
}
