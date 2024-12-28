<?php
namespace App\DataTableBuilders;

use App\Enums\ActiveStatus;
use App\Models\Admin\Department;
use App\Models\Admin\Setting;
use App\Services\Api\DataTableBuilder\AbstractDataTableBuilder;

class SettingsDataTableBuilder extends AbstractDataTableBuilder
{
    public $model=Setting::class;
    protected $tableName="settings";

    public function __construct(){
        parent::__construct();
    }

    public function columns()
    {
        $this->DataTableBuilder->setPaginateSizes([10,20,50,100]);
        $this->DataTableBuilder->setColumn("id",__("general.id"),"text",false);
        $this->DataTableBuilder->setColumn("slug",__("general.name"),function($value,$model){
            return __("basic_settings.".$value);
        },false);
        //$this->DataTableBuilder->setColumn("key",__("general.key_name"),"text",false);
        $this->DataTableBuilder->setColumn("value",__("general.value"),"text",false);
        $this->DataTableBuilder->setColumn("type",__("general.type"),"text",false);

        $this->DataTableBuilder->setColumn("actions","",function($value,$model)
        {

            $data['buttons'][]=[
                "type"=>"link",
                "title"=>"ویرایش",
                "route"=>route("admin.settings.basic_settings.edit",$model->id)
             ];


            return view("admin.vendor.table.actions",$data)->render();
        },false);
    }

    public function setMultiselect()
    {

    }

    public function toolbar()
    {

    }

    public function filterColumn()
    {


    }


}
