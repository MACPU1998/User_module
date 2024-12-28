<?php

namespace App\Http\Controllers\Admin;

use App\DataTableBuilders\TicketDataTableBuilder;
use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Tickets\TicketReplyRequest;
use App\Libraries\SMSIR;
use App\Models\Admin\Admin;
use App\Models\Admin\Ticket;
use App\Models\Admin\TicketMessage;
use App\Models\Admin\TicketMessageAttachment;
use App\Models\User;
use App\Services\Api\FileUploader\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TicketDataTableBuilder $ticketDataTableBuilder)
    {
        try {
            $ticketDataTableBuilder->query()->whereIn("department_id",adminDepartmentAccessIds());
            return view("admin.tickets.index",compact("ticketDataTableBuilder"));
        } catch (\Throwable $th) {
            return redirect(route("admin.tickets_management.tickets.index"))->with("error",errorMessage($th));
        }
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $ticket = Ticket::find($id);
            $ticket_messages = TicketMessage::where("ticket_id",$ticket->id)->get();
            return view("admin.tickets.messages",compact("ticket",'ticket_messages'));
        } catch (\Throwable $th) {
            return redirect(route("admin.tickets_management.tickets.index"))->with("error",errorMessage($th));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
        try {
            $ticket = Ticket::find($id);

            TicketMessage::where("ticket_id",$ticket->id)->delete();

            TicketMessageAttachment::where("ticket_id",$ticket->id)->delete();

            $ticket->delete();
        } catch (\Throwable $th) {
            return redirect(route("admin.tickets_management.tickets.index"))->with("error",errorMessage($th));
        }
    }

    public function reply(TicketReplyRequest $request,$ticket_id)
    {
        DB::beginTransaction();
        try {
            $ticket_message_data=[
                "ticket_id" => $ticket_id,
                "creator_id" => auth()->guard("admin")->user()->id,
                "creator_type" => Admin::class,
                "message" => $request->message,
                "ip" => $request->ip(),
            ];
            $ticket_message = TicketMessage::create($ticket_message_data);

            if($request->hasFile("files"))
            {
                foreach($request->file("files") as $file)
                {
                    $fu = new FileUploader();
                    $fu->setUploadDisk("public");
                    $fu->setUploadPath("files/tickets/".$ticket_id);
                    $fu->upload($file);

                    $ticket_message_attachment_data=[
                        "ticket_id" => $ticket_id,
                        "ticket_message_id" => $ticket_message->id,
                        "file" => $fu->getFileName(),
                    ];
                    TicketMessageAttachment::create($ticket_message_attachment_data);
                }
            }
            $ticket = Ticket::find($ticket_id);
            $ticket->update(["status"=>TicketStatus::REPLIED->value]);

            DB::commit();
            $creator = User::find($ticket->creator_id);
            if($creator){
                $param = [
                    [
                        "name" => "NAME",
                        "value" => $creator->first_name." ".$creator->last_name
                    ],
                    [
                        "name" => "TICKETNUMBER",
                        "value" => "#" . $ticket->code
                    ],
                ];
                SMSIR::sendRegularSms($creator->mobile,"763998",$param);
//                SMSIR::sendRegularSms($creator->mobile,"355501",$param);
            }

            return back()->with("message",__("message.send_successfull"));
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with("error",errorMessage($th));
        }

    }

    public function attachmentDownload($attachment)
    {
        try {
            $attachment = decrypt($attachment);
            $ticket_attachment = TicketMessageAttachment::find($attachment);
            $path = "files/tickets/".$ticket_attachment->ticket_id."/".$ticket_attachment->file;
            return Storage::download($path);
        } catch (\Throwable $th) {
            return back()->with("error",errorMessage($th));
        }

    }

    public function changeStatus(Request $request,$ticket_id)
    {
        try {
            Ticket::find($ticket_id)->update(["status"=>$request->status]);
            return response()->json([],200);
        } catch (\Throwable $th) {
            return response()->json([],500);
        }
    }
}
