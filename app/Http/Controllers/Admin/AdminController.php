<?php

namespace App\Http\Controllers\Admin;

use App\DataTableBuilders\AdminDataTableBuilder;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminCreateRequest;
use App\Http\Requests\Admin\AdminUpdateRequest;
use App\Models\Admin\Admin;
use App\Models\Admin\Department;
use App\Models\Admin\Role;
use App\Services\Api\FileUploader\FileUploader;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AdminDataTableBuilder $adminDatatableBuilder)
    {
        return view("admin.admins.index",compact('adminDatatableBuilder'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $roles = Role::select("id","name")->where("active",true)->get();
        $roles= generateObjectForComponent($roles,"name","id");
        $departments = Department::select("id","name")->where("active",true)->get();
        $departments= generateObjectForComponent($departments,"name","id");
        return view("admin.admins.create",compact('roles','departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminCreateRequest $request)
    {
        try {

            DB::beginTransaction();
            $data=[
                "first_name"=>$request->first_name,
                "last_name"=>$request->last_name,
                "email"=>$request->email,
                "phone"=>$request->phone,
                "password"=>bcrypt($request->password),
                "status"=>$request->status,
            ];
            $admin = Admin::create($data);
            // ------------->assign role to admin<------------
            $role = Role::find($request->role);
            $admin->assignRole($role->name);

            // ------------->add department data<------------
            if($request->has("department_id"))
            {
                $departments = Department::whereIn("id",$request->department_id)->where("active",true)->get();
                $admin->departments()->sync($departments);
            }



            // ------------>image upload<-------------
            if ($request->has("image")) {
                $this->addAdminImage($request->image,$admin);
            }

            DB::commit();
            return redirect(route("admin.admins_management.admins.index"))->with("message",__("message.add_successfull"));
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect(route("admin.admins_management.admins.index"))->with("error",errorMessage($th));
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
        $admin = Admin::with("departments")->find($id);
        $roles = Role::select("id","name")->where("active",true)->get();
        $roles= generateObjectForComponent($roles,"name","id");
        $departments = Department::select("id","name")->where("active",true)->get();
        $departments= generateObjectForComponent($departments,"name","id");
        return view("admin.admins.edit",compact('admin','roles','departments'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminUpdateRequest $request, string $id)
    {
        try {
            DB::beginTransaction();

            $admin = Admin::find($id);
            $data=[
                "first_name"=>$request->first_name,
                "last_name"=>$request->last_name,
                "email"=>$request->email,
                "phone"=>$request->phone,
                "status"=>$request->status,
            ];
            if($request->has('password'))
                $data['password'] = bcrypt($request->password);
            $admin->update($data);
            // ------------->assign role to admin<------------
            $role = Role::find($request->role);
            $admin->syncRoles($role);

            // ------------->add department data<------------
            if($request->has("department_id"))
            {

                $departments = Department::whereIn("id",$request->department_id)->where("active",true)->get();
                $admin->departments()->sync($departments);
            }




            // ------------>image upload<-------------

            if ($request->has("image")) {
                // --------->remove old image<--------
                if($admin->image)
                    $this->removeAdminImage($admin);
                // ---------->add new image<-------------
                $this->addAdminImage($request->image,$admin);
            }
            DB::commit();
            return redirect(route("admin.admins_management.admins.index"))->with("message",__("message.update_successfull"));

        } catch (\Throwable $th) {
            DB::rollback();
            return redirect(route("admin.admins_management.admins.index"))->with("error",errorMessage($th));
        }



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            // ----------->remove admin<-------
            $admin = Admin::find($id);
            if(!$admin->deletable)
                return back()->with("error",__("message.no_deletable"));
            $role = $admin->roles()->first();
            $admin->delete();


            // ----------->unassign role<----------

            $admin->removeRole($role->name);

            // ----------->remove image<-----------
            if($admin->image)
                $this->removeAdminImage($admin);

            DB::commit();
            return redirect(route("admin.admins_management.admins.index"))->with("message",__("message.remove_successfull"));

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect(route("admin.admins_management.admins.index"))->with("error",errorMessage($th));
        }



    }

    public function addAdminImage($imageRequest,Admin $admin)
    {
        $fu = new FileUploader();
        $fu->setUploadDisk("public");
        $fu->setUploadPath("images/avatars/".$admin->id);
        $fu->upload($imageRequest);
        $admin->update([
            "image" => $fu->getFileName()
        ]);
    }
    public function removeAdminImage(Admin $admin){
        $fu = new FileUploader();
        $fu->setUploadDisk("public");
        $fu->setUploadPath("images/avatars/".$admin->id);
        $fu->setFileName($admin->image);
        $fu->remove();
    }

    public function bulkDelete()
    {

    }
}
