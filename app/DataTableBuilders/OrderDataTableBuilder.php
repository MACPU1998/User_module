<?php
namespace App\DataTableBuilders;

use App\Enums\OrderStatus;
use App\Enums\ProjectStatus;
use App\Models\Admin\SalePartner;
use App\Models\Order;
use App\Services\Api\DataTableBuilder\AbstractDataTableBuilder;

class OrderDataTableBuilder extends AbstractDataTableBuilder
{
    public $model = Order::class;
    protected $tableName = "orders";

    public function __construct(){
        parent::__construct();
    }

    public function columns()
    {
        $this->DataTableBuilder->setPaginateSizes([10,20,50,100]);
        $this->DataTableBuilder->setColumn("code",__("general.code"),"text",true);
        $this->DataTableBuilder->setColumn("sale_partner_id",__("general.sale_partner"),function($value, $model){
            return "<a href='".route('admin.sale_partners_management.sale_partners.edit',$model->salePartner?->id)."'>".$model->salePartner?->last_name."</a>";
        },true);
        $this->DataTableBuilder->setColumn("description",__("general.description"),"text",true);
        $this->DataTableBuilder->setColumn("status",__("general.status"),function ($value){
            if($value==1)
                return "<span class='badge bg-label-warning'>ثبت اولیه</span>";
            elseif($value==2)
                return "<span class='badge bg-label-success'>تایید شده</span>";
            elseif($value==3)
                return "<span class='badge bg-label-info'>آماده ارسال</span>";
            elseif($value==4)
                return "<span class='badge bg-label-info'>ارسال شد</span>";
            elseif($value==5)
                return "<span class='badge bg-label-success'>دریافت شد</span>";
            elseif($value==0)
                return "<span class='badge bg-label-danger'>لغو</span>";

        },true);

        $this->DataTableBuilder->setColumn("created_at",__("general.created_at"),function($value,$model){
            return $model->jalali_created_at;
        },true,null,"dir-ltr text-center w-200px");
        $this->DataTableBuilder->setColumn("actions","",function($value,$model)
        {
            $data['buttons'][]=[
                "type"=>"link",
                "title"=>"ویرایش",
                "route"=>route('admin.sale_partners_management.orders.edit',$model->id),
                "attributes"=>[],
                "permission"=>"admin.sale_partners_management.orders.edit",
            ];
            $data['buttons'][]=[
                "type"=>"delete",
                "title"=>"حذف",
                "row_id"=>$model->id,
                "route"=>route('admin.sale_partners_management.orders.destroy',$model->id),
                "attributes"=>[],
                "permission"=>"admin.sale_partners_management.orders.destroy",
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
        $users = SalePartner::all();
        $users = generateObjectForComponent($users,"full_name","id");        $status = generateObjectForComponent(OrderStatus::toCollect(),"name","value");

        $this->DataTableBuilder->setFilterColumn("code","filter_code","text","%","col-md-3");
        $this->DataTableBuilder->setFilterColumn("sale_partner_id","filter_sale_partner","select","=","col-md-3",$users);
        $this->DataTableBuilder->setFilterColumn("created_at", ["filter_from_created_at", "filter_to_created_at"], "range:date", "=");
        $this->DataTableBuilder->setFilterColumn("status", "filter_status", "select", "=","col-md-3",$status);
    }
}
