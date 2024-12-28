<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\AppSlider;
use Response;

class AppController extends ApiController
{
    public function sliders()
    {
        $sliders = AppSlider::where("status",1)->orderBy("id","DESC")->get();

        return Response::success(data: $sliders);
    }
}
