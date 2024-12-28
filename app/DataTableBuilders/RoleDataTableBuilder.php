<?php
namespace App\DataTableBuilders;

use App\Enums\ActiveStatus;
use App\Models\Admin\Role;
use App\Services\Api\DataTableBuilder\AbstractDataTableBuilder;

class RoleDataTableBuilder extends AbstractDataTableBuilder
{
    public $model=Role::class;
    protected $tableName="roles";

    public function __construct(){
        parent::__construct();
    }

    public function columns()
    {
        $this->DataTableBuilder->setPaginateSizes([10,20,50,100]);
        $this->DataTableBuilder->setColumn("name",__("general.name"),"text",false);
        $this->DataTableBuilder->setColumn("sort",__("general.sort"),"text",true);
        $this->DataTableBuilder->setColumn("active",__("general.status"),function($value,$model){
            return ActiveStatus::getHtmlStyle($value);
        },false,null);
        $this->DataTableBuilder->setColumn("created_at",__("general.created_at"),function($value,$model){
            return $model->jalali_created_at;
        },false,null,"dir-ltr text-center w-200px");



        $this->DataTableBuilder->setColumn("actions","",function($value,$model)
        {



            $data['buttons'][]=[
                "type"=>"link",
                "title"=>"دسترسی ها",
                "route"=>route("admin.admins_management.role.permissions",$model->id)
             ];
            $data['buttons'][]=[
                "type"=>"link",
                "title"=>"ویرایش",
                "route"=>route("admin.admins_management.roles.edit",$model->id)
             ];
            $data['buttons'][]=[
                "type"=>"delete",
                "title"=>"حذف",
                "row_id"=>$model->id,
                "route"=>route('admin.admins_management.roles.destroy',$model->id),
                "attributes"=>[],
                "permission"=>"admin.admins_management.roles.destroy",
            ];

            return view("admin.vendor.table.actions",$data)->render();
        },false);
    }

    public function setMultiselect()
    {
        // $this->DataTableBuilder->setMultiSelectStatus(true);
        // $this->DataTableBuilder->setMultiSelectButton("btn_bulk_delete",__("general.bulk_delete"),"admin.admins_management.admins.bulk_delete",null,"cross-circle",[],"admin.admins_management.admins.bulk_delete");
        // $this->DataTableBuilder->setMultiSelectButton("btn_bulk_changestatus",__("general.change_status"),"admins_management.admins.bulk_changestatus",null,"arrows-circle",[],"admins_management.admins.bulk_changestatus");

        // $this->DataTableBuilder->setMultiSelectButtonData("btn_bulk_changestatus","changestatus_to_active",__("general.active"),encryptValue(AdminStatus::ACTIVE->value,"status"),"check-square",[],"admin_changestatus_to_active");
        // $this->DataTableBuilder->setMultiSelectButtonData("btn_bulk_changestatus","changestatus_to_deactive",__("general.deactive"),encryptValue(AdminStatus::DEACTIVE->value,"status"),"cross-square",[],"admin_changestatus_to_deactive");
        // $this->DataTableBuilder->setMultiSelectButtonData("btn_bulk_changestatus","changestatus_to_ban",__("general.ban"),encryptValue(AdminStatus::BAN->value,"status"),"minus-square",[],"admin_changestatus_to_ban");
    }

    public function toolbar()
    {
        $this->DataTableBuilder->setToolButton(
                __("general.add_role"),
                route('admin.admins_management.roles.create'),
                "btn-primary btn-icon-light",
                "ki-outline ki-plus-square",
                [],
                "admin.admins_management.roles.create"
        );
    }

    public function filterColumn()
    {


    }


}
