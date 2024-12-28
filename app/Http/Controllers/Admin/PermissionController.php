<?php

namespace App\Http\Controllers\Admin;

use App\DataTableBuilders\PermissionDataTableBuilder;
use App\Enums\ActiveStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Permissions\PermissionUpdateRequest;
use App\Models\Admin\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PermissionDataTableBuilder $permissionDataTableBuilder)
    {
        return view("admin.permissions.index",compact('permissionDataTableBuilder'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sort = Permission::max('sort');
        $sort++;
        $permissions = Permission::where("parent",0)->where("active",ActiveStatus::ACTIVE->value)->orderBy("id","asc")->get();
        $permissions = generateObjectForComponent($permissions,"slug","id");
        return view("admin.permissions.create",compact("sort","permissions"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionUpdateRequest $request)
    {
        // try {
            $data=[
                "name"=>$request->name,
                "slug"=>$request->slug,
                "parent"=>$request->parent ?? 0,
                "sort"=>$request->sort,
                "active"=>$request->active,
            ];
            Permission::create($data);
            return redirect(route("admin.admins_management.permissions.index"))->with("message",__("message.add_successfull"));
        // } catch (\Throwable $th) {
        //     return redirect(route("admin.admins_management.permissions.index"))->with("error",errorMessage($th));
        // }
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
        try {
            $permission = Permission::find($id);
            return view("admin.permissions.edit",compact("permission"));
        } catch (\Throwable $th) {
            return redirect(route("admin.admins_management.permissions.index"))->with("error",errorMessage($th));
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
