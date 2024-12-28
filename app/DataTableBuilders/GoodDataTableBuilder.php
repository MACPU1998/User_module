<?php
namespace App\DataTableBuilders;

use App\Models\Good;
use App\Services\Api\DataTableBuilder\AbstractDataTableBuilder;

class GoodDataTableBuilder extends AbstractDataTableBuilder
{
    public $model=Good::class;
    protected $tableName="goods";

    public function __construct(){
        parent::__construct();
    }

    public function columns()
    {
        $this->DataTableBuilder->setPaginateSizes([10,20,50,100]);
        $this->DataTableBuilder->setColumn("title",__("general.title"),"text",true);
        $this->DataTableBuilder->setColumn("media",__("general.thumbnail"),function ($value, $model){
            $media = $model->getFirstMediaUrl("goods");
            return "<img class='img-thumbnail' width=64 src='". $media ."' />";
        },true);
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
                "route"=>route('admin.sale_partners_management.goods.edit',$model->id),
                "attributes"=>[],
                "permission"=>"admin.sale_partners_management.goods.edit",
            ];
            $data['buttons'][]=[
                "type"=>"delete",
                "title"=>"حذف",
                "row_id"=>$model->id,
                "route"=>route('admin.sale_partners_management.goods.destroy',$model->id),
                "attributes"=>[],
                "permission"=>"admin.sale_partners_management.goods.destroy",
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
            route('admin.sale_partners_management.goods.create'),
            "btn-primary btn-icon-light",
            "bx bxs-user-plus",
            [],
            "admin.sale_partners_management.goods.create"
        );
    }

    public function filterColumn()
    {
        // CAST : INTEGER,float8,TEXT

        $this->DataTableBuilder->setFilterColumn("title","filter_title","text","%","col-md-3");
    }
}
