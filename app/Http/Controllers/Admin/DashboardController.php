<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProject;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::whereNotNull("id")->get();
        $projects = UserProject::all();
        $data['all_users']=["data"=>$users->count(),"url"=>route("user.users_management.users.index")];
        $data['pending_users'] = ["data"=>$users->where("status",0)->count(),"url"=>route("admin.users_external_filter",encrypt("users|status|0"))];
        $data['accepted_users'] = ["data"=>$users->where("status",1)->count(),"url"=>route("admin.users_external_filter",encrypt("users|status|1"))];
        $data['rejected_users'] = ["data"=>$users->where("status",2)->count(),"url"=>route("admin.users_external_filter",encrypt("users|status|2"))];
        $data['block_users'] = ["data"=>$users->where("status",3)->count(),"url"=>route("admin.users_external_filter",encrypt("users|status|3"))];

        $data['pending_projects'] = ["data"=>$projects->where("status",1)->count(),"url"=>route("admin.userproject_external_filter",encrypt("user_projects|status|1"))];
        $data['accepted_projects'] = ["data"=>$projects->where("status",2)->count(),"url"=>route("admin.userproject_external_filter",encrypt("user_projects|status|2"))];
        $data['rejected_projects'] = ["data"=>$projects->where("status",3)->count(),"url"=>route("admin.userproject_external_filter",encrypt("user_projects|status|3"))];
        $data['block_projects'] = ["data"=>$projects->where("status",4)->count(),"url"=>route("admin.userproject_external_filter",encrypt("user_projects|status|4"))];
        return view("admin.index",$data);
    }
}
