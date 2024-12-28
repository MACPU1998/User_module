<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\AppVersion;
use Illuminate\Support\Facades\Storage;
use Response;

class AppVersionController extends ApiController
{
    public function last()
    {
        $app = AppVersion::where("status",1)->orderBy("id","DESC")->first();
        $app->download_link = route("app.version.latest");

        return Response::success(data: $app);
    }

    public function downloadLatestApp()
    {

        $app = AppVersion::where("status",1)->orderBy("id","DESC")->first();
        $path = "applications/".$app->file;
        if (Storage::disk('local')->exists($path)) {
            $file = Storage::path($path);
            $headers =  [
                'Content-Type'=>'application/vnd.android.package-archive',
                'Content-Disposition'=> 'attachment; filename="'.$app->file.'"',
            ];
            return response()->download($file,null,$headers );
        }
        return response()->noContent(404);
    }

    public function changeStatus()
    {
        return response()->json(["data"=>"on"]);
    }
}
