<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\UserStatus;
use App\Http\Requests\Api\V1\SalePartnerDocumentUpdate;
use App\Http\Requests\Api\V1\SalePartnerProfileImageUpdate;
use App\Http\Requests\Api\V1\SalePartnerProfileUpdate;
use App\Http\Requests\Api\V1\SendTicketRequest;
use App\Http\Requests\Api\V1\UserDocumentUpdate;
use App\Http\Requests\Api\V1\UserProfileUpdate;
use App\Models\Admin\SalePartner;
use App\Models\Admin\Ticket;
use App\Models\Admin\TicketMessage;
use App\Models\Admin\TicketMessageAttachment;
use App\Models\UserProject;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

use function PHPSTORM_META\map;

class SalePartnerController extends ApiController
{
    /**
     * @return Response
     */
    public function information()
    {
        try {
            $data = auth("salePartner")->user();
//            $data->id_card_file = auth("salePartner")->user()->id_card_file ? asset("storage/".auth()->guard("salePartner")->user()->id_card_file) : null;
//            $data->personal_picture_file = $data->personal_image_file =auth()->guard("salePartner")->user()->personal_image_file ? asset("storage/".auth()->guard("salePartner")->user()->personal_image_file) : null;
//

            return Response::success(data: $data);
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
            $salePartner = auth("salePartner")->user();
            if($salePartner->walletable)
                return Response::success(data: ["balance" => $salePartner->walletable->balance]);
            return response(content: ["message"=>"کاربر یافت نشد"],status: 404);
        }
        catch (\Exception $exception){
                return Response::error(
                    code: 500,
                    message: $exception->getMessage()
                );
        }
    }

    public function updateProfile(SalePartnerProfileUpdate $request)
    {
        try{
            $salePartner = auth("salePartner")->user();
            if($salePartner){
                $personalPictureFileDir = null;
                if($request->has('personal_picture')) {
                    $personalPictureFile = $request->file('personal_picture');
                    $personalPictureFileName = strtotime('now') . '.' . $personalPictureFile->extension();
                    $personalPictureFileDir = $personalPictureFile->storeAs('sale_partners/personal_pictures', $personalPictureFileName,
                        ['disk' => 'disk']);
                    if($salePartner->personal_image_file){
                        if(File::exists(storage_path('app/public/'.$salePartner->personal_image_file)))
                        {
                            File::delete(storage_path('app/public/'.$salePartner->personal_image_file));
                        }
                    }
                }
                $data = [
                    "address"=>$request->address,
                    "phone"=>$request->phone,
                    "postal_code"=>$request->postal_code,
                    "bank_account_number"=>$request->bank_account_number,
                    "bank_sheba"=>$request->bank_sheba,
                    "bank_card_number"=>$request->bank_card_number,
                    //"status"=>UserStatus::PENDING->value,
                ];
                if($personalPictureFileDir)
                    $data['personal_image_file'] = $personalPictureFileDir;

                $salePartner->update($data);
                return Response::success(data: $salePartner);
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

    public function updateProfileImage(SalePartnerProfileImageUpdate $request)
    {
        try{
            $salePartner = auth("salePartner")->user();
            if($salePartner && $salePartner->status != 3){
                $personalPictureFileDir = null;

                if($request->has('personal_picture_file')) {
                    $personalPictureFile = $request->file('personal_picture_file');
                    $personalPictureFileName = strtotime('now') . '.' . $personalPictureFile->extension();
                    $personalPictureFileDir = $personalPictureFile->storeAs('sale_partners/personal_pictures/', $personalPictureFileName,
                        ['disk' => 'disk']);
                    if($salePartner->personal_image_file){
                        if(File::exists(storage_path('app/public/'.$salePartner->personal_image_file)))
                        {
                            File::delete(storage_path('app/public/'.$salePartner->personal_image_file));
                        }
                    }
                }


                if($personalPictureFileDir)
                    $data['personal_image_file'] = $personalPictureFileDir;

                $salePartner->update($data);
                return Response::success();
            }
            elseif ($salePartner->status == 3)
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

    public function sendTicket(SendTicketRequest $request)
    {
        try {

            $ticket_data = [
                "creator_id"=>auth("salePartner")->user()->id,
                "creator_type"=>SalePartner::class,
                "title"=>$request->title,
                "department_id"=>$request->department_id,
            ];
            $ticket = Ticket::create($ticket_data);

            $data_ticket_message = [
                "ticket_id"=>$ticket->id,
                "creator_id"=>auth("salePartner")->user()->id,
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
