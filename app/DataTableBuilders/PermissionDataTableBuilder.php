<?php
namespace App\DataTableBuilders;

use App\Models\Admin\Permission;
use App\Services\Api\DataTableBuilder\AbstractDataTableBuilder;


class PermissionDataTableBuilder extends AbstractDataTableBuilder
{
    public $model=Permission::class;

    protected $tableName="permissions";

    public function __construct(){
        parent::__construct();
    }

    public function columns()
    {
        $this->DataTableBuilder->setPaginateSizes([10,20,50,100]);
        $this->DataTableBuilder->setColumn("slug",__("general.name"),function($value,$mode){
                return __("permissions.".$value);
        },false);
        $this->DataTableBuilder->setColumn("name",__("general.permission_name"),"text",false);
        $this->DataTableBuilder->setColumn("sort",__("general.sort"),"text",true,"float8");
        // $this->DataTableBuilder->setColumn("parent",__("general.parent"),function($value,$model){
        //     return $model->parentInfo?->name;
        // },false);
        $this->DataTableBuilder->setColumn("active",__("general.status"),"getGeneralStatus",false,null);
        $this->DataTableBuilder->setColumn("created_at",__("general.created_at"),function($value,$model){
            return $model->jalali_created_at;
        },false,null,"dir-ltr text-center w-200px");




    }

    public function setMultiselect()
    {
        $this->DataTableBuilder->setMultiSelectStatus(false);

    }

    public function toolbar()
    {
        $this->DataTableBuilder->setToolButton(
            __("general.add_permission"),
            route('admin.admins_management.permissions.create'),
            "btn-primary btn-icon-light",
            "ki-outline ki-plus-square",
            [],
            "admin.admins_management.permissions.create"
        );
    }

    public function filterColumn()
    {


    }


}
