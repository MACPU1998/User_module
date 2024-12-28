<?php

namespace App\Http\Controllers\UserManagement;

use App\DataTableBuilders\UserDataTableBuilder;
use App\Enums\Gender;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserUpdate;
use App\Libraries\SMSIR;
use App\Models\Admin\SalePartner;
use App\Models\Admin\Setting;
use App\Models\City;
use App\Models\Province;
use App\Models\User;
use App\Services\Api\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserDataTableBuilder $userDataTableBuilder)
    {
        // $data['adminDatatableBuilder']=$adminDatatableBuilder;
        return view("admin.users.index",compact('userDataTableBuilder'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $user = User::find($id);
        $provinces = Province::all();
        $cities = City::all();
        $provinces = generateObjectForComponent($provinces,"name","id");
        $cities = generateObjectForComponent($cities,"name","id");
        $genders = Gender::toCollect();
        $status = UserStatus::toCollect();
        $genders = generateObjectForComponent($genders,"name","id");
        $status = generateObjectForComponent($status,"name","id");
        return view("admin.users.edit")->with(['user' => $user, 'genders' => $genders, 'status' => $status,
            'provinces'=>$provinces, 'cities'=>$cities]);
    }

    public function coinEdit(string $id)
    {
        //
        $user = User::find($id);
        return view("admin.users.edit-coin")->with(['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdate $request, string $id)
    {
        //
        try{
            $data = $request->all();
            $bd = explode("/",$request->birthdate);
            $data["birthdate"] = jalali_to_gregorian($bd[0],$bd[1],$bd[2],"-");
            $user = User::find($id);
            if($user){
                if($request->hasFile('id_card_file')){

                    $idCardFileDir = (new FileUploadService())
                    ->setPath('id_cards')
                    ->setExistingFilePath($user->id_card_file)
                    ->upload($request->file('id_card_file'));

                    $data["id_card_file"] = $idCardFileDir;
                }
                else
                    unset($data["id_card_file"]);

                if($request->hasFile('personal_picture_file')){

                    $personalPictureFileDir = (new FileUploadService())
                    ->setPath('personal_pictures')
                    ->setExistingFilePath($user->personal_picture_file)
                    ->upload($request->file('personal_picture_file'));

                    $data["personal_picture_file"] = $personalPictureFileDir;
                }
                else
                    unset($data["personal_picture_file"]);

                if($request->hasFile('document_file')){

                    $documentFileDir = (new FileUploadService())
                    ->setPath('documents')
                    ->setExistingFilePath($user->document_file)
                    ->upload($request->file('document_file'));

                    $data["document_file"] = $documentFileDir;
                }
                else
                    unset($data["document_file"]);

                if($user->status == 0 && $data["status"] == 1 && $user->walletable->balance == 0){
                    $setting = Setting::where("key","coin_count_on_registered")->first();
                    if($setting && is_numeric($setting->value)){
                        $credit = $setting->value==null||$setting->value==0?1:$setting->value;
                        $user->walletable->update([
                            "balance" => $user->walletable->balance + $credit
                        ]);
                        $param = [
                            [
                                "name" => "NAME",
                                "value" => $user->first_name." ".$user->last_name
                            ],
                            [
                                "name" => "COIN",
                                "value" => $credit
                            ],
                        ];
                        SMSIR::sendRegularSms($user->mobile,"331115",$param);
//                        SMSIR::sendRegularSms($user->mobile,"805750",$param);
                    }

                }
                if($data["status"] == 2){
                    $param = [
                        [
                            "name" => "NAME",
                            "value" => $user->first_name." ".$user->last_name,
                        ],
                        [
                            "name" => "COMMENT",
                            "value" => ($user->comment&&strlen($user->comment)>5)?
                                "توضیجات کارشناس:"." ".$user->comment:
                                " ",
                        ],
                    ];
                    SMSIR::sendRegularSms($user->mobile,"916869",$param);
//                    SMSIR::sendRegularSms($user->mobile,"207739",$param);
                }

                $user->update($data);

                return back()->with("message",__("message.update_successfull"));
            }
            else{
                return back()->with("error","message.user_not_found");
            }
        }
        catch(\Exception $e){
            return back()->with("error","message.error_occured");
        }
    }

    public function updateCoin(Request $request, string $id)
    {
        $validated = $request->validate([
            'coin' => 'required|integer|min:0,max:100000',
        ]);
        try{
            $user = User::find($id);
            if($user){
                $user->walletable->update([
                    "balance" => $request->coin
                ]);
                $user->update([
                    "coin" => $request->coin
                ]);
                return back()->with("success","message.update_successful");
            }
            else{
                return back()->with("error","message.error_occured");
            }
        }
        catch(\Exception $e){
            return back()->with("error","message.error_occured");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::find($id);
        if($user){
            $user->delete();
            return back()->with("success","حذف با موفقیت انجام شد");
        }
        return back()->with("error","کاربر یافت نشد!");

    }

    public function bulkDelete()
    {

    }

    public function externalFilter($table_field_value)
    {
        try {
            $table_field_value = decrypt($table_field_value);
            list($table,$field,$value)= explode("|",$table_field_value);
            session([$table."_filter"=>["filter_".$field=>$value]]);
            session(["hasFilter"=>true]);
            return redirect(route("user.users_management.users.index"));
        } catch (\Throwable $th) {
            return back()->with("error",errorMessage($th));
        }
    }
}
