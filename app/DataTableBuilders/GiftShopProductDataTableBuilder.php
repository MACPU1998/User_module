<?php
namespace App\DataTableBuilders;

use App\Models\GiftShopProduct;
use App\Services\Api\DataTableBuilder\AbstractDataTableBuilder;

class GiftShopProductDataTableBuilder extends AbstractDataTableBuilder
{
    public $model=GiftShopProduct::class;
    protected $tableName="gift_shop_product";

    public function __construct(){
        parent::__construct();
    }

    public function columns()
    {
        $this->DataTableBuilder->setPaginateSizes([10,20,50,100]);
        $this->DataTableBuilder->setColumn("title",__("general.title"),"text",true);
        $this->DataTableBuilder->setColumn("thumbnail",__("general.thumbnail"),"image:assets/images/giftshopproducts|local",true);
        $this->DataTableBuilder->setColumn("cost_value",__("general.cost"),"text",true);
        $this->DataTableBuilder->setColumn("status",__("general.status"),function ($value){
            if($value==0)
                return "<span class='badge bg-label-warning'>غیرفعال</span>";
            elseif($value==1)
                return "<span class='badge bg-label-success'>فعال</span>";

        },true);

        $this->DataTableBuilder->setColumn("created_at",__("general.created_at"),function($value,$model){
            return $model->jalali_created_at;
        },true,null,"dir-ltr text-center w-200px");
        $this->DataTableBuilder->setColumn("actions","",function($value,$model)
        {
            $data['buttons'][]=[
                "type"=>"link",
                "title"=>"ویرایش",
                "route"=>route('user.users_management.giftshop_products.edit',$model->id),
                "attributes"=>[],
                "permission"=>"user.users_management.giftshop_products.edit",
            ];
            $data['buttons'][]=[
                "type"=>"delete",
                "title"=>"حذف",
                "row_id"=>$model->id,
                "route"=>route('user.users_management.giftshop_products.destroy',$model->id),
                "attributes"=>[],
                "permission"=>"user.users_management.giftshop_products.destroy",
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
            __("general.add_product"),
            route('user.users_management.giftshop_products.create'),
            "btn-primary btn-icon-light",
            "bx bxs-user-plus",
            [],
            "user.users_management.giftshop_products.create"
        );
    }

    public function filterColumn()
    {
        // CAST : INTEGER,float8,TEXT

        $this->DataTableBuilder->setFilterColumn("title","filter_title","text","%","col-md-3");
    }
}
