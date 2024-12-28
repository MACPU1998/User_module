<?php

namespace Database\Seeders;

use App\Models\Admin\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings=[
            [
                "slug" => "app_update",
                "key" => "app_update",
                "value" => 1,
                "type" => "bool",
                "show_in_list" => true,
            ],
            [
                "slug" => "coin_count_per_100_litr",
                "key" => "coin_count_per_100_litr",
                "value" => 1,
                "type" => "text",
                "show_in_list" => true,
            ],
            [
                "slug" => "coin_count_on_registered",
                "key" => "coin_count_on_registered",
                "value" => 10,
                "type" => "text",
                "show_in_list" => true,
            ],
            [
                "slug" => "app_version",
                "key" => "app_version",
                "value" => "1.0.1",
                "type" => "text",
                "show_in_list" => true,
            ],
            [
                "slug" => "program_title",
                "key" => "program_title",
                "value" => "",
                "type" => "text",
                "show_in_list" => false,
            ],
            [
                "slug" => "phone",
                "key" => "phone",
                "value" => "",
                "type" => "text",
                "show_in_list" => false,
            ],
            [
                "slug" => "email",
                "key" => "email",
                "value" => "",
                "type" => "text",
                "show_in_list" => false,
            ],
            [
                "slug" => "rules_content",
                "key" => "rules_content",
                "value" => "",
                "type" => "editor",
                "show_in_list" => false,
            ],

        ];
        DB::beginTransaction();
        Setting::whereNotNull("id")->delete();
        foreach($settings as $setting)
        {
            Setting::create($setting);
        }
        DB::commit();
    }
}
