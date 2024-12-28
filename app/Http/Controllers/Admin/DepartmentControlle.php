<?php

namespace App\Http\Controllers\Admin;

use App\DataTableBuilders\DepartmentDataTableBuilder;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BasicData\DepartmentRequest;
use App\Models\Admin\Department;
use Illuminate\Http\Request;

class DepartmentControlle extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DepartmentDataTableBuilder $departmentDataTableBuilder)
    {
        return view("admin.basic_data.departments.index",compact('departmentDataTableBuilder'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sort = Department::max('sort');
        $sort = $sort++;
        $sort = $sort ?? 1;
        return view("admin.basic_data.departments.create",compact("sort"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentRequest $request)
    {
        try {
            $data=[
                "name" => $request->name,
                "slug" => $request->slug,
                "sort" => $request->sort,
                "active" => $request->active,
            ];
            Department::create($data);
            return redirect(route("admin.basic_data_management.department.index"))->with("message",__("message.add_successfull"));
        } catch (\Throwable $th) {
            return back()->with("error",errorMessage($th));
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
        $department = Department::find($id);
        return view("admin.basic_data.departments.edit",compact("department"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $data = [
                "name"=>$request->name,
                "slug"=>$request->name,
                "sort" => $request->sort,
                "active" => $request->active,
            ];
            Department::find($id)->update($data);
            return redirect(route("admin.basic_data_management.department.index"))->with("message",__("message.update_successfull"));
        } catch (\Throwable $th) {
            return back()->with("error",errorMessage($th));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $department = Department::find($id);
            $department->delete();
            return redirect(route("admin.basic_data_management.department.index"))->with("message",__("message.remove_successfull"));
        } catch (\Throwable $th) {
            return redirect(route("admin.basic_data_management.department.index"))->with("error",errorMessage($th));
        }
    }

    public function bulkDelete()
    {

    }
}
