<?php

namespace App\Http\Controllers\Admin;

use App\DataTableBuilders\SalePartnerDataTableBuilder;
use App\Enums\Gender;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SalePartner\StoreSalePartnerRequest;
use App\Http\Requests\Admin\SalePartner\UpdateSalePartnerRequest;
use App\Libraries\SMSIR;
use App\Models\Admin\SalePartner;
use App\Models\City;
use App\Models\CoinWallet;
use App\Models\Province;
use App\Services\Api\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SalePartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SalePartnerDataTableBuilder $salePartnerDataTableBuilder)
    {
        // $data['adminDatatableBuilder']=$adminDatatableBuilder;
//        $sp = SalePartner::all();
//        foreach ($sp as $p){
//            $coin = $p->walletable->balance;
//            $p->update([
//                "coin" => $coin
//            ]);
//        }
        return view("admin.sale_partners.index",compact('salePartnerDataTableBuilder'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = Province::all();
        $cities = City::all();
        $provinces = generateObjectForComponent($provinces,"name","id");
        $cities = generateObjectForComponent($cities,"name","id");
        $genders = Gender::toCollect();
        $status = UserStatus::toCollect();
        $genders = generateObjectForComponent($genders,"name","id");
        $status = generateObjectForComponent($status,"name","id");
        return view("admin.sale_partners.create",compact('provinces','cities','genders','status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSalePartnerRequest $request)
    {
        try {
            $data = $request->all();
            $bd = explode("/",$request->birthdate);
            $data["birthdate"] = jalali_to_gregorian($bd[0],$bd[1],$bd[2],"-");
            if($request->hasFile('id_card_file')){
                $idCardFileDir = (new FileUploadService())
                ->setPath('sale_partners/id_cards')
                ->upload($request->file('id_card_file'));

                $data["id_card_file"] = $idCardFileDir;
            }
            else
                unset($data["id_card_file"]);

            if($request->hasFile('personal_image_file')
            ){
                $personalPictureFileDir = (new FileUploadService())
                ->setPath('sale_partners/personal_pictures')
                ->upload($request->file('personal_image_file'));

                $data["personal_image_file"] = $personalPictureFileDir;
            }
            else
                unset($data["personal_image_file"]);

            if($request->hasFile('contract_picture')
            ){
                $contractPictureDir = (new FileUploadService())
                ->setPath('sale_partners/contract_pictures')
                ->upload($request->file('contract_picture'));

                $data["contract_picture"] = $contractPictureDir;
            }
            else
                unset($data["contract_picture"]);

            if($request->hasFile('guarantees_picture')
            ){
                $contractPictureDir = (new FileUploadService())
                ->setPath('sale_partners/guarantees_pictures')
                ->upload($request->file('guarantees_picture'));

                $data["guarantees_picture"] = $contractPictureDir;
            }
            else
                unset($data["guarantees_picture"]);



            $salePartner = SalePartner::create($data);
            CoinWallet::create([
                "walletable_id" => $salePartner->id,
                "walletable_type" => SalePartner::class,
                "address" => generateRandomString(),
                "balance" => 0,
                "status" => 1
            ]);
            return redirect(route("admin.sale_partners_management.sale_partners.index"))->with("message",__("message.add_successfull"));

        } catch (\Throwable $th) {
            return redirect(route("admin.sale_partners_management.sale_partners.index"))->with("error",errorMessage($th));
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
        //
        $salePartner = SalePartner::find($id);
        $provinces = Province::all();
        $cities = City::all();
        $provinces = generateObjectForComponent($provinces,"name","id");
        $cities = generateObjectForComponent($cities,"name","id");
        $genders = Gender::toCollect();
        $status = UserStatus::toCollect();
        $genders = generateObjectForComponent($genders,"name","id");
        $status = generateObjectForComponent($status,"name","id");
        return view("admin.sale_partners.edit")->with(['salePartner' => $salePartner, 'genders' => $genders, 'status' => $status,
            'provinces'=>$provinces, 'cities'=>$cities]);
    }

     public function coinEdit(string $id)
     {
         //
         $salePartner = SalePartner::find($id);
         return view("admin.sale_partners.edit-coin")->with(['salePartner' => $salePartner]);
     }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSalePartnerRequest $request, string $id)
    {
        //
        try{
            $data = $request->all();
            $bd = explode("/",$request->birthdate);
            $data["birthdate"] = jalali_to_gregorian($bd[0],$bd[1],$bd[2],"-");
            $salePartner = SalePartner::find($id);
            if($salePartner){
                if($request->hasFile('id_card_file')){

                    $idCardFileDir = (new FileUploadService())
                    ->setPath('sale_partners/id_cards')
                    ->setExistingFilePath($salePartner->id_card_file)
                    ->upload($request->file('id_card_file'));


                    $data["id_card_file"] = $idCardFileDir;
                }
                else
                    unset($data["id_card_file"]);

                if($request->hasFile('personal_image_file')){
                    $personalPictureFileDir = (new FileUploadService())
                    ->setPath('sale_partners/personal_pictures')
                    ->setExistingFilePath($salePartner->personal_image_file)
                    ->upload($request->file('personal_image_file'));
                    $data["personal_picture_file"] = $personalPictureFileDir;
                }
                else
                    unset($data["personal_picture_file"]);

                if($request->hasFile('contract_picture')){
                    $contractPictureFileDir = (new FileUploadService())
                    ->setPath('sale_partners/contract_pictures')
                    ->setExistingFilePath($salePartner->contract_picture)
                    ->upload($request->file('contract_picture'));
                    $data["contract_picture"] = $contractPictureFileDir;
                }
                else
                    unset($data["contract_picture"]);

                if($request->hasFile('guarantees_picture')){
                    $guaranteesPictureFileDir = (new FileUploadService())
                    ->setPath('sale_partners/guarantees_pictures')
                    ->setExistingFilePath($salePartner->guarantees_picture)
                    ->upload($request->file('guarantees_picture'));
                    $data["guarantees_picture"] = $guaranteesPictureFileDir;
                }
                else
                    unset($data["guarantees_picture"]);

                $salePartner->update($data);

                return redirect(route("admin.sale_partners_management.sale_partners.index"))->with("message",__("message.update_successfull"));
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
             $salePartner = SalePartner::find($id);
             if($salePartner){
                 $salePartner->walletable->update([
                     "balance" => $request->coin
                 ]);
                 $salePartner->update([
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
        $salePartner = SalePartner::findOrFail($id);
        if($salePartner){
            if($salePartner->id_card_file)
            {
                (new FileUploadService())
                    ->setExistingFilePath($salePartner->id_card_file)
                    ->delete();
            }
            if($salePartner->personal_image_file)
            {
                (new FileUploadService())
                    ->setExistingFilePath($salePartner->personal_image_file)
                    ->delete();
            }
            if($salePartner->contract_picture)
            {
                (new FileUploadService())
                    ->setExistingFilePath($salePartner->contract_picture)
                    ->delete();
            }
            if($salePartner->guarantees_picture)
            {
                (new FileUploadService())
                    ->setExistingFilePath($salePartner->guarantees_picture)
                    ->delete();
            }
            $salePartner->delete();
            return back()->with("success","حذف با موفقیت انجام شد");
        }
        return back()->with("error","کاربر یافت نشد!");

    }

    // public function bulkDelete()
    // {

    // }

    // public function externalFilter($table_field_value)
    // {
    //     try {
    //         $table_field_value = decrypt($table_field_value);
    //         list($table,$field,$value)= explode("|",$table_field_value);
    //         session([$table."_filter"=>["filter_".$field=>$value]]);
    //         session(["hasFilter"=>true]);
    //         return redirect(route("user.users_management.users.index"));
    //     } catch (\Throwable $th) {
    //         return back()->with("error",errorMessage($th));
    //     }
    // }
}
