<?php

namespace App\Http\Controllers\Api\V1\Common;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class SettingController extends Controller
{

    public function rules()
    {
        $rules = getSetting("rules_content");

        return Response::success(
            data: $rules
        );
    }

}
