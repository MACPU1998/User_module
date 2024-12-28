<?php

namespace App\Http\Controllers\Api\V1\Common;

use App\Enums\ActiveStatus;
use App\Http\Controllers\Controller;
use App\Models\Admin\Department;
use App\Models\City;
use App\Models\Province;
use Illuminate\Support\Facades\Response;

class DepartmentController extends Controller
{

    public function getDepartments()
    {
        $depratments = Department::select("id","name")->where("active",ActiveStatus::ACTIVE->value)->get();

        return Response::success(
            data: $depratments
        );
    }
    public function cities()
    {
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
}
