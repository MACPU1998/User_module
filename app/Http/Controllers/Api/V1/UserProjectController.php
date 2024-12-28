<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\ProjectStatus;
use App\Http\Requests\Api\V1\UserProjectCreateRequest;
use App\Http\Requests\Api\V1\UserProjectUpdateRequest;
use App\Models\UserProject;
use App\Models\UserProjectItem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class UserProjectController extends ApiController
{
    public function projects()
    {
        try {
            return Response::success(data: auth()->user()->projects);
        }
        catch(\Exception $exception){
            return Response::error(
                code: 500,
                message: $exception->getMessage()
            );
        }
    }

    public function createProject(UserProjectCreateRequest $request)
    {
        try {
            $user = auth()->user();
            $data = $this->uploadProjectPicture($request);
            $more = [
                "code"=>date("ymdis").rand(1000,9999),
                "user_id" => $user->id,
                "status" => ProjectStatus::PENDING->value
            ];
            $data = array_merge($data,$more);
            $project = UserProject::create($data);
            foreach ($data["serial_number"] as $serial)
                UserProjectItem::create([
                   "user_project_id" => $project->id,
                   "serial" => $serial,
                    "status" => 1,
                    "title" => "درانتظار بررسی..."
                ]);
            return Response::success(data: $project);
        }
        catch (\Exception $exception){
                return Response::error(
                    code: 500,
                    message: $exception->getMessage()
                );
        }
    }

    public function updateProject(UserProjectUpdateRequest $request,$id)
    {
        $project = UserProject::find($id);
        $user = auth()->user();
        try {
            if($project && $project->user_id == $user->id && $project->status == 4){
                if($request->has("picture1") && $request->picture1 &&  $project->picture1)
                    Storage::delete("userprojects/".$project->picture1);
                if($request->has("picture2") && $request->picture2 &&  $project->picture2)
                    Storage::delete("userprojects/".$project->picture2);
                if($request->has("picture3") && $request->picture3 &&  $project->picture3)
                    Storage::delete("userprojects/".$project->picture3);
                if($request->has("picture4") && $project->picture4 &&  $project->picture4)
                    Storage::delete("userprojects/".$project->picture4);
                if($request->has("picture5") && $project->picture5 &&  $project->picture5)
                    Storage::delete("userprojects/".$project->picture5);
                $data = $this->uploadProjectPicture($request);
                $more = [
                    "status" => ProjectStatus::PENDING->value
                ];
                $data = array_merge($data,$more);
                $project->update($data);
                $project->items()->delete();
                foreach ($data["serial_number"] as $serial)
                    UserProjectItem::create([
                        "user_project_id" => $project->id,
                        "serial" => $serial,
                        "status" => 1,
                        "title" => "در انتظار بررسی..."
                    ]);
                return Response::success(data: $project);
            }
            return Response::error(
                code: 403,
                message: "عدم دسترسی"
            );

        }
        catch (\Exception $exception){
            return Response::error(
                code: 500,
                message: $exception->getMessage()
            );
        }
    }

    public function getProject($id)
    {
        try {
            $project = UserProject::where("id",$id)->with("items")->first();
            if($project && $project->user_id == auth()->user()->id)
                return Response::success(data: $project);
            else
                return Response::error(
                    code: 404,
                    message: "not found!"
                );
        } catch (\Exception $exception){
            return Response::error(
                code: 500,
                message: $exception->getMessage()
            );
        }

    }

    public function uploadProjectPicture($request){
        $data = $request->all();
        if($request->has("picture1") && $request->picture1){
            $pic1File = $request->file('picture1');
            $pic1FileName = random_int(1234,9999).strtotime('now').'.'.$pic1File->extension();
            $pic1FileDir = $pic1File->storeAs('userprojects', $pic1FileName, ['disk' => 'disk']);
            $data['picture1'] = $pic1FileName;
        }

        if($request->has("picture2") && $request->picture2){
            $pic2File = $request->file('picture2');
            $pic2FileName = random_int(1234,9999).strtotime('now').'.'.$pic2File->extension();
            $pic2FileDir = $pic2File->storeAs('userprojects', $pic2FileName, ['disk' => 'disk']);
            $data['picture2'] = $pic2FileName;
        }

        if($request->has("picture3") && $request->picture3){
            $pic3File = $request->file('picture3');
            $pic3FileName = random_int(1234,9999).strtotime('now').'.'.$pic3File->extension();
            $pic3FileDir = $pic3File->storeAs('userprojects', $pic3FileName, ['disk' => 'disk']);
            $data['picture3'] = $pic3FileName;
        }

        if($request->has("picture4") && $request->picture4){
            $pic4File = $request->file('picture4');
            $pic4FileName = random_int(1234,9876).strtotime('now').'.'.$pic4File->extension();
            $pic4FileDir = $pic4File->storeAs('userprojects', $pic4FileName, ['disk' => 'disk']);
            $data['picture4'] = $pic4FileName;
        }

        if($request->has("picture5") && $request->picture5){
            $pic5File = $request->file('picture5');
            $pic5FileName = random_int(1234,9999).strtotime('now').'.'.$pic5File->extension();
            $pic5FileDir = $pic5File->storeAs('userprojects', $pic5FileName, ['disk' => 'disk']);
            $data['picture5'] = $pic5FileName;
        }

        return $data;
    }


    public function getProjectPicture($project_id,$fileName)
    {
        // try {
            $project = UserProject::where("id", $project_id)->where("user_id", auth()->user()->id)->first();
            if ($project) {
                $path = "userprojects/" . $fileName;
                if (Storage::disk('local')->exists($path)) {
                    $image = Storage::response($path);

                    return $image;
                }

                return Response::error(null,404);
            }
        // } catch (\Exception $exception) {
        //     return Response::error(
        //         code: 500,
        //         message: $exception->getMessage()
        //     );
        // }
    }
}
