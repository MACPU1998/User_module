<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
//            AdminSeeder::class,
            PermissionsSeeder::class,
//            RolesSeeder::class,
//            RolePermissionSeeder::class,
//            RoleAdminSeeder::class,
//            DepartmentSeeder::class,
//            LocationsSeeders::class,
//            UserSeeder::class,
           SettingsSeeder::class,
        ]);
        $this->logOut();
    }
    public function logOut()
    {
        session()->forget("selected_role");
        Auth::guard('admin')->logout();
        session()->invalidate();
        session()->regenerateToken();
        Cache::flush();
    }
}
