<?php

namespace App\Http\Controllers\Admin;

use App\DataTableBuilders\TicketCategoryDataTableBuilder;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Tickets\TicketCategoryRequest;
use App\Models\Admin\TicketCategory;
use Illuminate\Http\Request;

class TicketCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TicketCategoryDataTableBuilder $ticketCategoryDataTableBuilder)
    {
        return view("admin.tickets.ticket_category.index",compact('ticketCategoryDataTableBuilder'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sort = TicketCategory::max('sort');
        $sort = $sort++;
        $sort = $sort ?? 1;
        return view("admin.tickets.ticket_category.create",compact("sort"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketCategoryRequest $request)
    {
        try {
            $data=[
                "name" => $request->name,
                "slug" => $request->slug,
                "sort" => $request->sort,
                "active" => $request->active,
            ];
            TicketCategory::create($data);
            return redirect(route("admin.tickets_management.tickets_categories.index"))->with("message",__("message.add_successfull"));
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
        $ticket_category = TicketCategory::find($id);
        return view("admin.tickets.ticket_category.edit",compact("ticket_category"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TicketCategoryRequest $request, string $id)
    {
        try {
            $data = [
                "name"=>$request->name,
                "slug"=>$request->name,
                "sort" => $request->sort,
                "active" => $request->active,
            ];
            TicketCategory::find($id)->update($data);
            return redirect(route("admin.tickets_management.tickets_categories.index"))->with("message",__("message.update_successfull"));
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
            $ticket_category = TicketCategory::find($id);
            $ticket_category->delete();
            return redirect(route("admin.tickets_management.tickets_categories.index"))->with("message",__("message.remove_successfull"));
        } catch (\Throwable $th) {
            return redirect(route("admin.tickets_management.tickets_categories.index"))->with("error",errorMessage($th));
        }
    }

    public function bulkDelete()
    {

    }
}
