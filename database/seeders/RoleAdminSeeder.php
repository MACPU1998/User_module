<?php

namespace Database\Seeders;

use App\Models\Admin\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $super_admin_role=Role::where("name","super admin")->first();
        $admin_role=Role::where("name","admin")->first();

        $super_admin=Admin::where("email","super_admin@gmail.com")->first();
        $admin=Admin::where("email","admin@gmail.com")->first();

        $super_admin->assignRole($super_admin_role);
        $admin->assignRole($admin_role);

    }
}
