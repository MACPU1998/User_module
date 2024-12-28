<?php
namespace App\DataTableBuilders;

use App\Enums\ActiveStatus;
use App\Models\Admin\TicketCategory;
use App\Services\Api\DataTableBuilder\AbstractDataTableBuilder;

class TicketCategoryDataTableBuilder extends AbstractDataTableBuilder
{
    public $model=TicketCategory::class;
    protected $tableName="ticket_categories";

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
                "title"=>"ویرایش",
                "route"=>route("admin.tickets_management.tickets_categories.edit",$model->id)
             ];
            $data['buttons'][]=[
                "type"=>"delete",
                "title"=>"حذف",
                "row_id"=>$model->id,
                "route"=>route('admin.tickets_management.tickets_categories.destroy',$model->id),
                "attributes"=>[],
                "permission"=>"admin.tickets_management.tickets_categories.destroy",
            ];

            return view("admin.vendor.table.actions",$data)->render();
        },false);
    }

    public function setMultiselect()
    {

    }

    public function toolbar()
    {
        $this->DataTableBuilder->setToolButton(
                __("general.add_ticket_category"),
                route('admin.tickets_management.tickets_categories.create'),
                "btn-primary btn-icon-light",
                "ki-outline ki-plus-square",
                [],
                "admin.tickets_management.tickets_categories.create"
        );
    }

    public function filterColumn()
    {


    }


}
