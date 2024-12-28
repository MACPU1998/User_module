<?php

namespace App\Http\Controllers\Api\V1\Common;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Province;
use Exception;
use Response;

class LocationController extends Controller
{

    public function provinces()
    {
        try {
            $provinces = Province::query()
                ->filter('search')
                ->select([
                    'id',
                    'name'
                ])
                ->get();

            return Response::success(
                data: $provinces
            );
        }
        catch (Exception $exception) {
            return Response::error(
                code: 500,
                message: $exception->getMessage()
            );
        }
    }
    public function cities()
    {
        try {
            $cities = City::query()
                ->filter('search', 'province_id')
                ->select([
                    'id',
                    'province_id',
                    'name',
                ])
                ->get();

            return Response::success(
                data: $cities
            );
        }
        catch (Exception $exception) {
            return Response::error(
                code: 500,
                message: $exception->getMessage()
            );
        }
    }
}
