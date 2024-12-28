<?php

namespace App\Http\Controllers\Admin;

use App\DataTableBuilders\UserProjectDataTableBuilder;
use App\Enums\ProjectStatus;
use App\Exports\UserProjectsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AjaxProjectItemUpdate;
use App\Http\Requests\Admin\UserProjectUpdate;
use App\Libraries\SMSIR;
use App\Models\UserProject;
use App\Models\UserProjectItem;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserProjectDataTableBuilder $projectDataTableBuilder)
    {
        return view("admin.user_projects.index",compact('projectDataTableBuilder'));
    }

    public function excel(UserProjectDataTableBuilder $projectDataTableBuilder)
    {
        return Excel::download(new UserProjectsExport($projectDataTableBuilder->lastQuery()), 'excel.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function coinEdit(string $id)
    {
        //
        $userProject = UserProject::find($id);
        return view("admin.user_projects.edit-coin")->with(['user_project' => $userProject]);
    }

    public function updateCoin(Request $request, string $id)
    {
        $validated = $request->validate([
            'coin' => 'required|integer|min:0|max:10000',
        ]);
        try{
            $userProject = UserProject::find($id);
            if($userProject){
                $userProject->update([
                    "credit" => $request->coin
                ]);
                return back()->with("success","message.update_successful");
            }
            else{
                return back()->with("error","message.update_occured");
            }
        }
        catch(\Exception $e){
            return back()->with("error","message.update_occured");
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $project = UserProject::find($id);
        $status = ProjectStatus::toCollect();
        $status = generateObjectForComponent($status,"name","value");
        return view("admin.user_projects.edit")->with(['model' => $project, 'status' => $status]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserProjectUpdate $userProjectUpdate, string $id)
    {
        //
        $project = UserProject::find($id);

        if($project){
            $user = $project->user;
            $data = $userProjectUpdate->all();
            if($userProjectUpdate->status==2){
                if($this->hasDuplicateItem($project))
                    return back()->with("error",__("به علت وجود محصول تکراری امکان تایید پروژه وجود ندارد!"));
                if($project->credit&&$project->credit>0)
                    $user->walletable->update([
                        "balance" => $user->walletable->balance + $project->credit
                    ]);

                $project->update(
                    $data
                );

                $param = [
                    [
                        "name" => "NAME",
                        "value" => $user->first_name." ".$user->last_name
                    ],
                    [
                        "name" => "TITLE",
                        "value" => "#".$project->code
                    ],
                ];
                SMSIR::sendRegularSms($user->mobile,"778060",$param);
//                SMSIR::sendRegularSms($user->mobile,"489755",$param);
                $param = [
                    [
                        "name" => "NAME",
                        "value" => $project->client_first_name." ".$project->client_last_name
                    ],
                ];
                SMSIR::sendRegularSms($project->client_phone,"761578",$param);
//                SMSIR::sendRegularSms($project->client_phone,"693997",$param);
            }elseif ($userProjectUpdate->status==3){
//                $project->items()->update([
//                   "status" => 3,
//                ]);
                if($project->credit&&$project->credit>0&&$project->status==2)
                    $user->walletable->update([
                        "balance" => $user->walletable->balance - $project->credit
                    ]);
                $data["credit"] = 0;
                $project->update(
                    $data
                );
                $param = [
                    [
                        "name" => "NAME",
                        "value" => $user->first_name." ".$user->last_name
                    ],
                    [
                        "name" => "TITLE",
                        "value" => "#".$project->code
                    ],
                    [
                        "name" => "COMMENT",
                        "value" => "* مشاهده در لیست پروژه *"
                    ],
                    [
                        "name" => "STATUS",
                        "value" => "رد شده"
                    ],
                ];
                SMSIR::sendRegularSms($user->mobile,"906565",$param);
//                SMSIR::sendRegularSms($user->mobile,"143130",$param);
            }elseif ($userProjectUpdate->status==4){
//                $project->items()->update([
//                    "status" => 3,
//                ]);
                if($project->credit&&$project->credit>0&&$project->status==2)
                    $user->walletable->update([
                        "balance" => $user->walletable->balance - $project->credit
                    ]);
                $data["credit"] = 0;
                $project->update(
                    $data
                );
                $param = [
                    [
                        "name" => "NAME",
                        "value" => $user->first_name." ".$user->last_name
                    ],
                    [
                        "name" => "TITLE",
                        "value" => "#".$project->code
                    ],
                    [
                        "name" => "STATUS",
                        "value" => "ّبازبینی"
                    ],
                ];
                SMSIR::sendRegularSms($user->mobile,"913828",$param);
//                SMSIR::sendRegularSms($user->mobile,"143130",$param);
            }
            elseif ($userProjectUpdate->status==1){
                $project->items()->update([
                    "status" => 1,
                ]);
                if($project->credit&&$project->credit>0&&$project->status==2)
                    $user->walletable->update([
                        "balance" => $user->walletable->balance - $project->credit
                    ]);
                $data["credit"] = 0;
                $project->update(
                    $data
                );
            }
            return back()->with("message",__("message.update_successfull"));
        }
        return back()->with("error",__("خطاء"));
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        UserProject::find($id)->delete();
        return redirect()->route("user.users_management.user_projects.index")->with("message",__("message.remove_successfull"));

    }

    public function bulkDelete()
    {

    }

    public function externalFilter($table_field_value)
    {
        try {
            $table_field_value = decrypt($table_field_value);
            list($table,$field,$value)= explode("|",$table_field_value);
            session([$table."_filter"=>["filter_".$field=>$value]]);
            session(["hasFilter"=>true]);
            return redirect(route("user.users_management.user_projects.index"));
        } catch (\Throwable $th) {
            return back()->with("error",errorMessage($th));
        }
    }

    public function hasDuplicateItem($project): bool
    {
        foreach ($project->items as $item){
                if($item->status==4){
                    return true;
                }
        }
        return false;
    }

    public function ajaxProjectItemUpdate(AjaxProjectItemUpdate $ajaxProjectItemUpdate){
        $item = UserProjectItem::find($ajaxProjectItemUpdate->item_id);
        try {
            if($item)
                $item->update([
                    "serial" => $ajaxProjectItemUpdate->serial_number,
                    "status" => 1,
                    "title" => "در انتظار بررسی..."
                ]);
            return Response()->json(["success"=>true],200);
        }
        catch (\Exception $e){
            return Response()->json(["success"=>false, "message"=>$e->getMessage()],200);
        }

    }
}
