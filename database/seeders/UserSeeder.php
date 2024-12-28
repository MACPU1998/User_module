<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Province;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users=[
            [
                "user_type" => "0",
                "first_name" => "mohammad",
                "last_name" => "mohammadi",
                "national_code" => "2150238977",
                "gender" => 1,
                "mobile" => "09119249360",
                "phone" => "01112345678",
                "address" => "ساری",
                "birthdate" => "1992-01-01",
                "education" => 3,
                "dress_size" => 2,
                "bank_account_number" => "11111111",
                "bank_sheba" => "11111111",
                "bank_card_number" => "11111111",
                "id_card_file" => "1.jpg",
                "personal_picture_file" => "2.jpg",
                "document_file" => "3.jpg",
                "postal_code" => "1234567890",
                "province_id" => Province::whereNotNull("id")->first()->id,
                "city_id" => City::whereNotNull("id")->first()->id,
                "status" => 1,
            ],

        ];
        DB::beginTransaction();

        User::whereNotNull("id")->withTrashed()->forceDelete();
        foreach($users as $user)
        {
            User::create($user);
        }
        DB::commit();
    }
}
