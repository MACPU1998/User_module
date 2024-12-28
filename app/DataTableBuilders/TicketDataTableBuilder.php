<?php
namespace App\DataTableBuilders;

use App\Enums\ActiveStatus;
use App\Enums\TicketStatus;
use App\Models\Admin\Admin;
use App\Models\Admin\Department;
use App\Models\Admin\Ticket;
use App\Services\Api\DataTableBuilder\AbstractDataTableBuilder;

class TicketDataTableBuilder extends AbstractDataTableBuilder
{
    public $model=Ticket::class;
    protected $tableName="tickets";

    public function __construct(){
        parent::__construct();
    }

    public function columns()
    {
        $this->DataTableBuilder->setPaginateSizes([10,20,50,100]);
        $this->DataTableBuilder->setColumn("code",__("general.code"),"text",true);
        $this->DataTableBuilder->setColumn("creator_info",__("general.full_name"),function($value,$model){
            return $model->ticketable?->full_name;
        },false);
        $this->DataTableBuilder->setColumn("creator_type",__("general.user_type"),function($value,$model){
            return ($value == Admin::class) ? '<span class="badge bg-label-success me-1">'.__("general.admin").'</span>' : '<span class="badge bg-label-warning me-1">'.__("general.user").'</span>' ;
        },true);
        $this->DataTableBuilder->setColumn("title",__("general.title"),"text",true);
        $this->DataTableBuilder->setColumn("department_id",__("general.department"),function($value,$model){
            return $model->department->name;
        },true);
        $this->DataTableBuilder->setColumn("status",__("general.status"),function($value,$model){
            return TicketStatus::getHtmlStyle($value);
        },false,null);
        $this->DataTableBuilder->setColumn("created_at",__("general.created_at"),function($value,$model){
            return $model->jalali_created_at;
        },false,null,"dir-ltr text-center w-200px");

        $this->DataTableBuilder->setColumn("actions","",function($value,$model)
        {

            $data['buttons'][]=[
                "type"=>"link",
                "title"=>__("general.messages"),
                "route"=>route("admin.tickets_management.tickets.show",$model->id)
             ];
            $data['buttons'][]=[
                "type"=>"delete",
                "title"=>"حذف",
                "row_id"=>$model->id,
                "route"=>route('admin.tickets_management.tickets.destroy',$model->id),
                "attributes"=>[],
                "permission"=>"admin.tickets_management.tickets.destroy",
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
        $departments = Department::where("active",true)->get();
        $departments = generateObjectForComponent($departments,"name","id");
        $this->DataTableBuilder->setFilterColumn("code","filter_code","text","%","col-md-3");
        $this->DataTableBuilder->setFilterColumn("title","filter_title","text","%","col-md-3");
        $this->DataTableBuilder->setFilterColumn("department_id","filter_department","select","=","col-md-3",$departments);
        $this->DataTableBuilder->setFilterColumn("status","filter_status","select","=","col-md-3",generateObjectForComponent(TicketStatus::toCollect(),"name","value"));

    }


}
