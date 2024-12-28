<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationsSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinces=[
            [
                "name" => "مازندران",
                "cities" =>[
                    ["name" => "ساری"]
                ],
                "active"=>1

            ],

        ];
        DB::beginTransaction();
        Province::whereNotNull("id")->delete();
        City::whereNotNull("id")->delete();
        foreach($provinces as $province)
        {
            $data_province=[
                "name"=>$province['name'],
                "active"=>1,
            ];
            $provinceInfo = Province::create($data_province);
            foreach($province['cities'] as $city)
            {
                $data_city = [
                    "province_id"=>$provinceInfo->id,
                    "name"=>$city['name'],
                    "active"=>1
                ];
                City::create($data_city);
            }
        }
        DB::commit();
    }
}
