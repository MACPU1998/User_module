<?php
namespace App\DataTableBuilders;

use App\Enums\UserStatus;
use App\Models\User;
use App\Services\Api\DataTableBuilder\AbstractDataTableBuilder;

class UserDataTableBuilder extends AbstractDataTableBuilder
{
    public $model=User::class;
    protected $tableName="users";

    public function __construct(){
        parent::__construct();
    }

    public function columns()
    {
        $this->DataTableBuilder->setPaginateSizes([10,20,50,100]);
        $this->DataTableBuilder->setColumn("first_name",__("general.first_name"),"text",true);
        $this->DataTableBuilder->mergeColumn("first_name","last_name",__("general.last_name"),"text",true,"text");
        $this->DataTableBuilder->setColumn("national_code",__("general.national_code"),"text",true);
        $this->DataTableBuilder->setColumn("mobile",__("general.mobile"),"text",true);
        $this->DataTableBuilder->setColumn("coin",__("general.coin"),"text",true);
        $this->DataTableBuilder->setColumn("status",__("general.status"),function ($value){
            if($value==0)
                return "<span class='badge bg-label-warning me-1'>در انتظار بررسی</span>";
            elseif($value==1)
                return "<span class='badge bg-label-success me-1'>تایید شده</span>";
            elseif($value==2)
                return "<span class='badge bg-label-danger me-1'>عدم تایید</span>";
            else
                return "<span class='badge bg-label-dark me-1'>مسدود</span>";
        },true);

        $this->DataTableBuilder->setColumn("created_at",__("general.created_at"),function($value,$model){
            return $model->jalali_created_at;
        },true,null,"dir-ltr text-center w-200px");
        $this->DataTableBuilder->setColumn("actions","",function($value,$model)
        {
            $data['buttons'][]=[
                "type"=>"link",
                "title"=>"ویرایش",
                //"row_id"=>$model->id,
                "route"=>route('user.users_management.users.edit',$model->id),
                "attributes"=>[],
                "permission"=>"user.users_management.users.edit",
            ];
            $data['buttons'][]=[
                "type"=>"link",
                "title"=>"ویرایش پلاسکوین",
                //"row_id"=>$model->id,
                "route"=>route('user.users_management.coin.edit',$model->id),
                "attributes"=>[],
                "permission"=>"user.users_management.coin.edit",
            ];
            $data['buttons'][]=[
                "type"=>"delete",
                "title"=>"حذف",
                "row_id"=>$model->id,
                "route"=>route('user.users_management.users.destroy',$model->id),
                "attributes"=>[],
                "permission"=>"user.users_management.users.destroy",
            ];

            return view("admin.vendor.table.actions",$data)->render();
        },false);
    }

    public function setMultiselect()
    {

    }

    public function toolbar()
    {
        // $this->DataTableBuilder->setToolButton(
        //         __("general.add_admin"),
        //         route('admin.admins_management.admins.create'),
        //         "btn-primary btn-icon-light",
        //         "ki-outline ki-plus-square",
        //         [],
        //         "admin.admins_management.admins.create"
        // );
    }

    public function filterColumn()
    {
        // CAST : INTEGER,float8,TEXT

        $this->DataTableBuilder->setFilterColumn("first_name","filter_first_name","text","%","col-md-3");
        $this->DataTableBuilder->setFilterColumn("last_name","filter_last_name","text","%","col-md-3");
        $this->DataTableBuilder->setFilterColumn("status","filter_status","select","=","col-md-3",generateObjectForComponent(UserStatus::toCollect(),"name","id"));


    }


}
