<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ActiveStatus;
use App\Models\Admin;
use App\Services\Api\GeoService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\Ruraldistrict;
use App\Models\Village;

class LocationController extends Controller
{
    public function getCities(Request $request)
    {
        $cities = City::where("active",ActiveStatus::ACTIVE->value)->get();
        $cities=$cities->map(function($item,$key) use($request){
            return [
                "name"=>$item->name,
                "hashid"=>$item->id,
                "selected"=> $item->id == $request->selectedItem
            ];
        });
        return response()->json($cities);
    }






}
