<?php

namespace App\Http\Controllers\Api\V1\Common;

use App\Enums\ActiveStatus;
use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Tickets\TicketReplyRequest;
use App\Http\Requests\Api\V1\TicketRequest;
use App\Models\Admin\Ticket;
use App\Models\Admin\TicketCategory;
use App\Models\Admin\TicketMessage;
use App\Models\Admin\TicketMessageAttachment;
use App\Models\User;
use App\Services\Api\FileUploader\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    public function getTicketCategories()
    {
        $ticket_categories = TicketCategory::where("active",ActiveStatus::ACTIVE->value)->get();
        return Response::success(
            data: $ticket_categories
        );
    }

    public function ticketRegister(TicketRequest $request)
    {

        DB::beginTransaction();
        try {
            $ticket_data = [
                "code"=>date("Ymd").rand(111,999),
                "creator_id"=>auth()->user()->id,
                "creator_type"=>User::class,
                "title"=>$request->title,
                "ticket_category_id"=>$request->ticket_category_id,
                "department_id"=>$request->department_id,
                "status"=>TicketStatus::PENDING->value,
            ];
            $ticket = Ticket::create($ticket_data);
            $ticket_message_data=[
                "ticket_id" => $ticket->id,
                "creator_id" => auth()->user()->id,
                "creator_type" => User::class,
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
                    $fu->setUploadPath("files/tickets/".$ticket->id);
                    $fu->upload($file);

                    $ticket_message_attachment_data=[
                        "ticket_id" => $ticket->id,
                        "ticket_message_id" => $ticket_message->id,
                        "file" => $fu->getFileName(),
                    ];
                    TicketMessageAttachment::create($ticket_message_attachment_data);
                }
            }
            DB::commit();
            return Response::success(null,200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return Response::error(
                code: 500,
                message: $exception->getMessage()
            );
        }
    }

    public function getTickets()
    {
        try {
            $tickets =Ticket::where("creator_type",User::class)->where("creator_id",auth()->user()->id)->get();
            $tickets = $tickets->map(function($item){
                return [
                    "id"=>$item->id,
                    "title"=>$item->title,
                    "category"=>["id"=>$item->ticket_category_id,"name"=>$item->ticketCategory->name],
                    "status"=>["id"=>$item->status,"name"=>TicketStatus::getName($item->status)],
                    "created_at"=>$item->created_at
                ];

            });
            return Response::success(data:$tickets);
        } catch (\Exception $exception) {
            return Response::error(
                code: 500,
                message: $exception->getMessage()
            );
        }

    }

    public function getTicketMessages($ticket_id)
    {
        try {
            $ticket =  Ticket::find($ticket_id);
            $ticket_messages = TicketMessage::where("ticket_id",$ticket_id)->get();

            $ticket = [
                "id"=>$ticket->id,
                "title"=>$ticket->title,
                "category"=>["id"=>$ticket->ticket_category_id,"name"=>$ticket->ticketCategory->name],
                "status"=>["id"=>$ticket->status,"name"=>TicketStatus::getName($ticket->status)],
                "created_at"=>$ticket->created_at
            ];

            $ticket_messages = $ticket_messages->map(function($item){
                return [
                    "id"=>$item->id,
                    "ticket_id"=>$item->ticket_id,
                    "user"=>["id"=>$item->creator_id,"name"=>$item->ticketMessagable->first_name." ".$item->ticketMessagable->last_name],

                    "message"=>$item->message,
                    "ip"=>$item->ip,
                    "created_at"=>$item->created_at
                ];

            });



            $data = [
                "ticket_detail"=>$ticket,
                "ticket_messages"=> $ticket_messages,
            ];
            return Response::success(data:$data);
        } catch (\Exception $exception) {
            return Response::error(
                code: 500,
                message: $exception->getMessage()
            );
        }

    }

    public function getTicketDetail($ticket_id)
    {
        try {
            $ticket = Ticket::where("creator_type",User::class)->where("creator_id",auth()->user()->id)->first();
            $ticket_detail = [
                "id"=>$ticket->id,
                "title"=>$ticket->title,
                "category"=>["id"=>$ticket->status,"name"=> $ticket->ticketCategory->name],
                "status"=>["id"=>$ticket->status,"name"=>TicketStatus::getName($ticket->status)],
                "created_at"=>$ticket->created_at
            ];
            return Response::success(data:$ticket_detail);
        } catch (\Exception $exception) {
            return Response::error(
                code: 500,
                message: $exception->getMessage()
            );
        }


    }

    public function reply(TicketReplyRequest $request,$ticket_id)
    {
        DB::beginTransaction();
        try {
            $ticket_message_data=[
                "ticket_id" => $ticket_id,
                "creator_id" => auth()->user()->id,
                "creator_type" => User::class,
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
            Ticket::find($ticket_id)->update(["status"=>TicketStatus::USERREPLY->value]);
            DB::commit();
            return Response::success();
        } catch (\Exception $exception) {
            DB::rollBack();
            return Response::error(
                code: 500,
                message: $exception->getMessage()
            );
        }

    }

    public function getTicketMessageAttachments($ticket_message_id)
    {
        try {
            $ticket_message_attachments = TicketMessageAttachment::where("ticket_message_id",$ticket_message_id)->get();
            $ticket_message_attachments = $ticket_message_attachments->map(function($item){
                return [
                    "file_name"=>$item->file,
                    "file_url"=>route("api.v1.user.tickets.attachment.download",encrypt($item->id)),
                ];
            });
            return Response::success(data:$ticket_message_attachments);
        } catch (\Exception $exception) {
            return Response::error(
                code: 500,
                message: $exception->getMessage()
            );
        }
    }
    public function attachmentDownload($attachment)
    {
        try {

            $attachment = decrypt($attachment);
            $ticket_attachment = TicketMessageAttachment::find($attachment);
            $path = "files/tickets/".$ticket_attachment->ticket_id."/".$ticket_attachment->file;

            return Storage::download($path);
        } catch (\Exception $exception) {
            return Response::error(
                code: 500,
                message: $exception->getMessage()
            );
        }

    }
}
