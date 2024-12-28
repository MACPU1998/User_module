<?php

namespace Database\Seeders;

use App\Models\Admin\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles=[
            [
                "name" => "super admin",
                "guard_name" => "admin",
                "sort" => 1,
                "active" => 1,
            ],
            [
                "name" => "admin",
                "guard_name" => "admin",
                "sort" => 2,
                "active" => 1,
            ]
        ];
        DB::beginTransaction();
        Role::where("guard_name","admin")->delete();
        foreach($roles as $role)
        {
            Role::create($role);
        }
        DB::commit();
    }
}
