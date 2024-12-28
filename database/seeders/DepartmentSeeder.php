<?php

namespace Database\Seeders;

use App\Models\Admin\Admin;
use App\Models\Admin\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments=[
            [
                "name" => "پشتیبانی",
                "slug" => "support",
                "sort" => 1,
                "active" => 1,
            ],

        ];
        DB::beginTransaction();
        Department::whereNotNull("id")->delete();
        foreach($departments as $department)
        {
            Department::create($department);
        }
        DB::commit();
    }
}
