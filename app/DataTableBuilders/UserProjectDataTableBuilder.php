<?php
namespace App\DataTableBuilders;

use App\Enums\ActiveStatus;
use App\Enums\AdminStatus;
use App\Enums\ProjectStatus;
use App\Models\Province;
use App\Models\User;
use App\Models\UserProject;
use App\Services\Api\DataTableBuilder\AbstractDataTableBuilder;

class UserProjectDataTableBuilder extends AbstractDataTableBuilder
{
    public $model=UserProject::class;
    protected $tableName="user_projects";

    public function __construct(){
        parent::__construct();
    }

    public function columns()
    {

        $this->DataTableBuilder->setPaginateSizes([10,20,50,100]);
        $this->DataTableBuilder->setColumn("code",__("general.project_code"),"text",true,null,"w-250px");
        $this->DataTableBuilder->setColumn("user_id",__("general.user"),function($value,$model){
            return "<a href='".route('user.users_management.users.edit',$model->user?->id)."'>".$model->user?->last_name."</a>";
        },true,null,"w-150px");

        $this->DataTableBuilder->setColumn("client_last_name",__("general.client"),function($value,$model){
            return "<span class='text-info'>".$model->client_first_name." ".$model->client_last_name."</span>";
        },true,null,"w-150px");
        $this->DataTableBuilder->setColumn("client_phone",__("general.client_phone"),function($value,$model){
            return "<span class='text-info'>".$model->client_phone."</span>";
        },true);
        $this->DataTableBuilder->setColumn("client_province_id",__("general.province"),function ($value,$model){
            return "<span class='span span-info'>".$model->province_name."</span>";
        },true);
        $this->DataTableBuilder->setColumn("client_city_id",__("general.city"),function ($value,$model){
            return "<span class='span span-info'>".$model->city_name."</span>";
        },true);
        $this->DataTableBuilder->setColumn("credit",__("general.coin"),"text",true);
        $this->DataTableBuilder->setColumn("status",__("general.status"),function ($value,$model){
            $badge = "";
            if($value==1)
                $badge.= "<span class='badge bg-label-warning'>در انتظار بررسی</span>";
            elseif($value==2)
                $badge.= "<span class='badge bg-label-success'>تایید شده</span>";
            elseif($value==3)
                $badge.= "<span class='badge bg-label-danger'>عدم تایید</span>";
            elseif($value==4)
                $badge.= "<span class='badge bg-label-danger'>بازبینی</span>";

            if(count($model->items)>0)
                foreach($model->items as $item){
                    if($item->status==4){
                        return $badge.= " <span class='badge bg-label-danger'>دارای محصول تکراری</span>";
                    }
                }
            return $badge;
        },true);

        $this->DataTableBuilder->setColumn("created_at",__("general.created_at"),function($value,$model){
            return $model->jalali_created_at;
        },true,null,"dir-ltr text-center w-200px");
        $this->DataTableBuilder->setColumn("actions","",function($value,$model)
        {
            $data['buttons'][]=[
                "type"=>"link",
                "title"=>"جزئیات",
                "route"=>route('user.users_management.user_projects.edit',$model->id),
                "attributes"=>[],
                "permission"=>"user.users_management.user_projects.edit",
            ];
            if($model->credit>0)
                $data['buttons'][]=[
                    "type"=>"link",
                    "title"=>"ویرایش پلاسکوین",
                    //"row_id"=>$model->id,
                    "route"=>route('user.users_management.project.coin.edit',$model->id),
                    "attributes"=>[],
                    "permission"=>"user.users_management.project.coin.edit",
                ];
//            $data['buttons'][]=[
//                "type"=>"delete",
//                "title"=>"حذف",
//                "row_id"=>$model->id,
//                "route"=>route('user.users_management.user_projects.destroy',$model->id),
//                "attributes"=>[],
//                "permission"=>"user.users_management.user_projects.destroy",
//            ];

            return view("admin.vendor.table.actions",$data)->render();
        },false);
    }

    public function setMultiselect()
    {

    }

    public function toolbar()
    {
        $this->DataTableBuilder->setToolButton(
            "EXCEL",
            route('user.users_management.project.excel'),
            "btn-primary btn-icon-light",
            "bx bxs-file",
            [],
            "user.users_management.project.excel"
        );
    }

    public function filterColumn()
    {
        // CAST : INTEGER,float8,TEXT

        $users = User::all();
        $users = generateObjectForComponent($users,"full_name","id");

        $provinces= Province::all();
        $provinces=$provinces->map(function($province){
            return [
                "name"=>$province->name,
                "value"=>$province->id,
            ];
        })->toArray();
        $provinces=arrayToObject($provinces);

        $status = generateObjectForComponent(ProjectStatus::toCollect(),"name","value");

        $this->DataTableBuilder->setFilterColumn("code","filter_code","text","%","col-md-3");
        $this->DataTableBuilder->setFilterColumn("user_id","filter_user","select","=","col-md-3",$users);
        $this->DataTableBuilder->setFilterColumn("client_province_id:province","filter_province","select","=","col-md-3",$provinces);
        $this->DataTableBuilder->setFilterColumn("client_city_id:city","filter_city","select:filter_province|admin.get_cities","=","col-md-3",null);
        $this->DataTableBuilder->setFilterColumn("created_at", ["filter_from_created_at", "filter_to_created_at"], "range:date", "=");
        $this->DataTableBuilder->setFilterColumn("status", "filter_status", "select", "=","col-md-3",$status);
    }
}
