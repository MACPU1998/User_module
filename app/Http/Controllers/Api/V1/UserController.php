<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\SendTicketRequest;
use App\Http\Requests\Api\V1\UserDocumentUpdate;
use App\Http\Requests\Api\V1\UserProfileUpdate;
use App\Models\Admin\Ticket;
use App\Models\Admin\TicketMessage;
use App\Models\Admin\TicketMessageAttachment;
use App\Models\UserProject;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Response;

use function PHPSTORM_META\map;

class UserController extends ApiController
{
    public function information()
    {
        try {
            $data = auth()->user();
            $data->id_card_file = auth()->user()->id_card_file ? asset("storage/".auth()->user()->id_card_file) : null;
            $data->personal_picture_file =auth()->user()->personal_picture_file ? asset("storage/".auth()->user()->personal_picture_file) : null;
            $data->document_file = auth()->user()->document_file ? asset("storage/".auth()->user()->document_file) : null;

            return Response::success(data: auth()->user());
        }
        catch(\Exception $exception){
            return Response::error(
                code: 500,
                message: $exception->getMessage()
            );
        }
    }

    public function getCoin()
    {
        try {
            $user = auth()->user();
            if($user->walletable)
                return Response::success(data: ["balance" => $user->walletable->balance]);
            return response(status: 404);
        }
        catch (\Exception $exception){
                return Response::error(
                    code: 500,
                    message: $exception->getMessage()
                );
        }
    }

    public function updateProfile(UserProfileUpdate $request)
    {
        try{
            $user = auth()->user();
            if($user){
                $personalPictureFileDir = null;
                if($request->has('personal_picture')) {
                    $personalPictureFile = $request->file('personal_picture');
                    $personalPictureFileName = strtotime('now') . '.' . $personalPictureFile->extension();
                    $personalPictureFileDir = $personalPictureFile->storeAs('personal_pictures', $personalPictureFileName,
                        ['disk' => 'disk']);
                    if($user->personal_picture_file){
                        if(File::exists(storage_path('app/public/personal_pictures'.$user->personal_picture_file)))
                        {
                            File::exists(storage_path('app/public/personal_pictures'.$user->personal_picture_file));
                        }
                    }
                }
                $data = $request->all();
                if($personalPictureFileDir)
                    $data['personal_picture_file'] = $personalPictureFileDir;

                $user->update($data);
                return Response::success(data: $user);
            }
            return Response::error(
                code: 404,
                message: "کاربری یافت نشد"
            );
        }
        catch(\Exception $exception){
            return Response::error(
                code: 500,
                message: $exception->getMessage()
            );
        }

    }

    public function updateDocument(UserDocumentUpdate $request)
    {
        try{
            $user = auth()->user();
            if($user && $user->status != 3){
                $personalPictureFileDir = $idCardFileDir = $documentFileDir = null;
                if($request->has('id_card_file')){
                    $idCardFile = $request->file('id_card_file');
                    $idCardFileName = strtotime('now') . '.' . $idCardFile->extension();
                    $idCardFileDir = $idCardFile->storeAs('id_cards', $idCardFileName, ['disk' => 'disk']);
                    if($user->id_card_file){
                        if(File::exists(storage_path('app/public/id_cards'.$user->id_card_file)))
                        {
                            File::exists(storage_path('app/public/id_cards'.$user->id_card_file));
                        }
                    }
                }

                if($request->has('personal_picture_file')) {
                    $personalPictureFile = $request->file('personal_picture_file');
                    $personalPictureFileName = strtotime('now') . '.' . $personalPictureFile->extension();
                    $personalPictureFileDir = $personalPictureFile->storeAs('personal_pictures', $personalPictureFileName,
                        ['disk' => 'disk']);
                    if($user->personal_picture_file){
                        if(File::exists(storage_path('app/public/personal_pictures'.$user->personal_picture_file)))
                        {
                            File::exists(storage_path('app/public/personal_pictures'.$user->personal_picture_file));
                        }
                    }
                }
                if($request->has('document_file')) {
                    $documentFile = $request->file('document_file');
                    $documentFileName = strtotime('now') . '.' . $documentFile->extension();
                    $documentFileDir = $documentFile->storeAs('documents', $documentFileName, ['disk' => 'disk']);
                    if($user->document_file){
                        if(File::exists(storage_path('app/public/documents'.$user->document_file)))
                        {
                            File::exists(storage_path('app/public/documents'.$user->document_file));
                        }
                    }
                }
//                $idCardFile = $request->file('id_card_file');
//
//                $documentFile = $request->file('document_file');
//
//                $idCardFileName = strtotime('now').'.'.$idCardFile->extension();
//
//                $documentFileName = strtotime('now').'.'.$documentFile->extension();
//
//                $idCardFileDir = $idCardFile->storeAs('id_cards', $idCardFileName, ['disk' => 'disk']);
//
//                $documentFileDir = $documentFile->storeAs('documents', $documentFileName, ['disk' => 'disk']);
                $is_picture = true;
                if($idCardFileDir){
                    $is_picture = false;
                    $data['id_card_file'] = $idCardFileDir;
                }

                if($documentFileDir){
                    $is_picture = false;
                    $data['document_file'] = $documentFileDir;
                }

                if($personalPictureFileDir){}
                    $data['personal_picture_file'] = $personalPictureFileDir;
                if(!$is_picture)
                    $data['status'] = 0;
                $user->update($data);
                return Response::success();
            }
            elseif ($user->status == 3)
                return Response::error(
                    code: 403,
                    message: "این عملیات مجاز نیست!"
                );
            else
                return Response::error(
                    code: 404,
                    message: "کاربری یافت نشد!"
                );
        }
        catch(\Exception $exception){
            return Response::error(
                code: 500,
                message: $exception->getMessage()
            );
        }
    }

    public function getProjects()
    {
        try {
            $user_projects = UserProject::select("title","client_name","client_address","client_province_id","client_city_id")->where("user_id",auth()->user()->id)->get();
            $user_projects->map(function($item){
                $item['client_province']=["value"=>$item->client_province_id,"name"=>$item->province->name];
                $item['client_city']=["value"=>$item->client_city_id,"name"=>$item->city->name];
                unset($item->client_province_id);
                unset($item->client_city_id);
                unset($item->province);
                unset($item->city);
            });
            return Response::success(data: $user_projects);

        } catch (\Exception $e){
            return response(content: ["message"=>$e->getMessage()],status: 500);
        }

    }

    public function sendTicket(SendTicketRequest $request)
    {
        try {

            $ticket_data = [
                "creator_id"=>auth()->user()->id,
                "creator_type"=>auth()->user()->user_type,
                "title"=>$request->title,
                "department_id"=>$request->department_id,
            ];
            $ticket = Ticket::create($ticket_data);

            $data_ticket_message = [
                "ticket_id"=>$ticket->id,
                "creator_id"=>auth()->user()->id,
                "replyer_id"=>null,
                "ip"=>$request->ip(),
                "message"=>$request->message,
            ];

            $ticket_message = TicketMessage::create($data_ticket_message);

            if($request->hasFile("file"))
            {
                $file = $request->file('file');
                $fileName = strtotime('now').'.'.$file->extension();
                $file->storeAs('tickets_attachments', $fileName, ['disk' => 'disk']);

                $data_ticket_message_attachment = [
                    "ticket_message_id"=>$ticket_message->id,
                    "file"=>$fileName,
                ];
                TicketMessageAttachment::create($data_ticket_message_attachment);
            }
            return Response::success();
        } catch (\Exception $e) {
            return response(content: ["message"=>$e->getMessage()],status: 500);
        }

    }
}
