<?php
namespace App\DataTableBuilders;

use App\Enums\AdminStatus;
use App\Models\Admin\Admin;
use App\Services\Api\DataTableBuilder\AbstractDataTableBuilder;

class AdminDataTableBuilder extends AbstractDataTableBuilder
{
    public $model=Admin::class;
    protected $tableName="admins";

    public function __construct(){
        parent::__construct();
    }

    public function columns()
    {
        $this->DataTableBuilder->setPaginateSizes([10,20,50,100]);
        $this->DataTableBuilder->setColumn("image",__("general.image"),function($value,$model){
            return imageGenerator("images/avatars/".$model->id."/".$value,"rounded","avatar","public",true);
        });
        $this->DataTableBuilder->setColumn("first_name",__("general.first_name"),"text",true);
        $this->DataTableBuilder->mergeColumn("first_name","last_name",__("general.last_name"),"text",false,null);
        $this->DataTableBuilder->setColumn("status",__("general.status"),function($value,$model){
            return AdminStatus::getHtmlStyle($value);
        },true,null);
        $this->DataTableBuilder->setColumn("created_at",__("general.created_at"),function($value,$model){
            return $model->jalali_created_at;
        },false,null,"dir-ltr text-center w-200px");



        $this->DataTableBuilder->setColumn("actions",__("general.action"),function($value,$model)
        {


            $data['buttons'][]=[
                "type"=>"link",
                "title"=>"ویرایش",
                "route"=>route("admin.admins_management.admins.edit",$model->id)
             ];
             if($model->deletable)
            $data['buttons'][]=[
                "type"=>"delete",
                "title"=>"حذف",
                "row_id"=>$model->id,
                "route"=>route('admin.admins_management.admins.destroy',$model->id),
                "attributes"=>[],
                "permission"=>"admin.admins_management.admins.destroy",
            ];

            return view("admin.vendor.table.actions",$data)->render();
        },false);
    }

    public function setMultiselect()
    {
        $this->DataTableBuilder->setMultiSelectStatus(true);
        $this->DataTableBuilder->setMultiSelectButton("btn_bulk_delete",__("general.bulk_delete"),"admin.admins_management.admins.bulk_delete",null,"cross-circle",[],"admin.admins_management.admins.bulk_delete");
        // $this->DataTableBuilder->setMultiSelectButton("btn_bulk_changestatus",__("general.change_status"),"admins_management.admins.bulk_changestatus",null,"arrows-circle",[],"admins_management.admins.bulk_changestatus");

        // $this->DataTableBuilder->setMultiSelectButtonData("btn_bulk_changestatus","changestatus_to_active",__("general.active"),encryptValue(AdminStatus::ACTIVE->value,"status"),"check-square",[],"admin_changestatus_to_active");
        // $this->DataTableBuilder->setMultiSelectButtonData("btn_bulk_changestatus","changestatus_to_deactive",__("general.deactive"),encryptValue(AdminStatus::DEACTIVE->value,"status"),"cross-square",[],"admin_changestatus_to_deactive");
        // $this->DataTableBuilder->setMultiSelectButtonData("btn_bulk_changestatus","changestatus_to_ban",__("general.ban"),encryptValue(AdminStatus::BAN->value,"status"),"minus-square",[],"admin_changestatus_to_ban");
    }

    public function toolbar()
    {
        $this->DataTableBuilder->setToolButton(
                __("general.add_admin"),
                route('admin.admins_management.admins.create'),
                "btn-primary btn-icon-light",
                "bx bxs-user-plus",
                [],
                "admin.admins_management.admins.create"
        );
    }

    public function filterColumn()
    {
        // CAST : INTEGER,float8,TEXT

        $this->DataTableBuilder->setFilterColumn("first_name","filter_first_name","text","%","col-md-3");
        $this->DataTableBuilder->setFilterColumn("last_name","filter_last_name","text","%","col-md-3");
        $this->DataTableBuilder->setFilterColumn("status","filter_status","select","=","col-md-3",generateObjectForComponent(AdminStatus::toCollect(),"name","value"));



    }


}
