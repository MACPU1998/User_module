<?php
namespace App\DataTableBuilders;

use App\Enums\OrderStatus;
use App\Models\GiftShopOrder;
use App\Models\GiftShopProduct;
use App\Models\User;
use App\Services\Api\DataTableBuilder\AbstractDataTableBuilder;

class GiftShopOrderDataTableBuilder extends AbstractDataTableBuilder
{
    public $model=GiftShopOrder::class;
    protected $tableName="gift_shop_orders";

    public function __construct(){
        parent::__construct();
    }

    public function columns()
    {
        $this->DataTableBuilder->setPaginateSizes([10,20,50,100]);
        $this->DataTableBuilder->setColumn("user_id",__("general.user"),function ($value,$model){
            return $model->userable?->first_name." ".$model->userable?->last_name;
        },true);
        $this->DataTableBuilder->setColumn("giftshop_product_id",__("general.giftshop_product"),function ($value,$model){
            return $model->giftShopProduct?->title;
        },true);
        $this->DataTableBuilder->setColumn("cost_value",__("general.cost"),"text",true);
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
                "route"=>route('user.users_management.giftshop_orders.edit',$model->id),
                "attributes"=>[],
                "permission"=>"user.users_management.giftshop_orders.edit",
            ];
//            $data['buttons'][]=[
//                "type"=>"delete",
//                "title"=>"حذف",
//                "row_id"=>$model->id,
//                "route"=>route('user.users_management.giftshop_orders.destroy',$model->id),
//                "attributes"=>[],
//                "permission"=>"user.users_management.giftshop_orders.destroy",
//            ];

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
        // CAST : INTEGER,float8,TEXT
        $users = User::all();
        $users = generateObjectForComponent($users,"full_name","id");
        $status = generateObjectForComponent(OrderStatus::toCollect(),"name","value");

        $this->DataTableBuilder->setFilterColumn("user_id","filter_user","select","=","col-md-3",$users);
        $this->DataTableBuilder->setFilterColumn("created_at", ["filter_from_created_at", "filter_to_created_at"], "range:date", "=");
        $this->DataTableBuilder->setFilterColumn("status", "filter_status", "select", "=","col-md-3",$status);

    }
}
