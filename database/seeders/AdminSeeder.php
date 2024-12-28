<?php

namespace Database\Seeders;

use App\Enums\ActiveStatus;
use App\Enums\AdminStatus;
use App\Models\Admin\Admin;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::whereNotNull("id")->delete();
        DB::table('admins')->insert([
            'first_name' => 'super admin',
            'last_name' => '',
            'email' => 'super_admin@gmail.com',
            'password' => bcrypt("123456789"),
            'status' => AdminStatus::ACTIVE->value,
            'deletable' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('admins')->insert([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt("123456789"),
            'status' => AdminStatus::ACTIVE->value,
            'deletable' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
