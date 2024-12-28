<?php

namespace App\Http\Controllers\Admin;

use App\DataTableBuilders\RoleDataTableBuilder;
use App\Enums\ActiveStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Roles\RoleRequest;
use App\Models\Admin\Admin;
use App\Models\Admin\Permission;
use App\Models\Admin\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RoleDataTableBuilder $roleDataTableBuilder)
    {

        return view("admin.roles.index",compact('roleDataTableBuilder'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sort = Role::max('sort');
        $sort = $sort++;
        return view("admin.roles.create",compact("sort"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        try {
            $data=[
                "name" => $request->name,
                "guard_name"=>"admin",
                "sort" => $request->sort,
                "active" => $request->active,
            ];
            Role::create($data);
            return redirect(route("admin.admins_management.roles.index"))->with("message",__("message.add_successfull"));
        } catch (\Throwable $th) {
            return redirect(route("admin.admins_management.roles.index"))->with("error",errorMessage($th));
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::find($id);
        return view("admin.roles.edit",compact("role"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, string $id)
    {
        try {
            $data=[
                "name" => $request->name,
                "guard_name"=>"admin",
                "sort" => $request->sort,
                "active" => $request->active,
            ];
            Role::find($id)->update($data);
            return redirect(route("admin.admins_management.roles.index"))->with("message",__("message.update_successfull"));
        } catch (\Throwable $th) {
            return redirect(route("admin.admins_management.roles.index"))->with("error",errorMessage($th));
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $role = Role::find($id);
            $admins_exist = Admin::whereHas("roles", function($q) use($role){ $q->where("name", $role->name); })->count();
            if($admins_exist)
                return redirect(route("admin.admins_management.roles.index"))->with("error",__("message.dependency_with_admins"));
            $role->delete();
            return redirect(route("admin.admins_management.roles.index"))->with("message",__("message.remove_successfull"));
        } catch (\Throwable $th) {
            return redirect(route("admin.admins_management.roles.index"))->with("error",errorMessage($th));
        }

    }

    public function permissions($role_id)
    {

        $permissions = Permission::where("active",ActiveStatus::ACTIVE->value)->orderBy("id","asc")->get()->toArray();
        $permissions = buildTree($permissions,"parent");
        $role = Role::find($role_id);
        $role_permissions = $role->permissions->pluck("name")->toArray();
        return view("admin.roles.permissions",compact("permissions","role_permissions","role"));
    }


    public function updatePermissions(Request $request,$role_id)
    {
        // try {
            $role = Role::find($role_id);
            if($request->has("permission"))
                $permission_selected = Permission::whereIn("name",$request->permission)->get();
            else
                $permission_selected = [];
            $role->syncPermissions($permission_selected);
            return redirect(route("admin.admins_management.roles.index"))->with("message",__("message.update_successfull"));
        // } catch (\Throwable $th) {
        //     return redirect(route("admin.admins_management.roles.index"))->with("error",errorMessage($th));
        // }


    }
}
