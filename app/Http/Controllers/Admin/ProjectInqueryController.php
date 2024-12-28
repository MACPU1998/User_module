<?php

namespace App\Http\Controllers\Admin;

use App\DataTableBuilders\UserProjectDataTableBuilder;
use App\Enums\ProjectStatus;
use App\Exports\UserProjectsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserProjectUpdate;
use App\Libraries\SMSIR;
use App\Models\UserProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ProjectInqueryController extends Controller
{

    public function inquery(){
        try {
            Artisan::call('app:project-item-inquery');
            return back()->with("message","استعلام انجام شد!");
        }
        catch (\Exception $e){
            return back()->with("error",__("خطاء"));
        }
    }
}
