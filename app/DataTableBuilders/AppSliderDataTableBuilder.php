<?php
namespace App\DataTableBuilders;

use App\Models\AppSlider;
use App\Services\Api\DataTableBuilder\AbstractDataTableBuilder;

class AppSliderDataTableBuilder extends AbstractDataTableBuilder
{
    public $model=AppSlider::class;
    protected $tableName="app_slider";

    public function __construct(){
        parent::__construct();
    }

    public function columns()
    {
        $this->DataTableBuilder->setPaginateSizes([10,20,50,100]);
        $this->DataTableBuilder->setColumn("media",__("general.thumbnail"),function ($value, $model){
            $media = $model->getFirstMediaUrl("slider");
            return "<img class='img-thumbnail' width=64 src='". $media ."' />";
        },true);
        $this->DataTableBuilder->setColumn("title",__("general.title"),"text",true);
        $this->DataTableBuilder->setColumn("link",__("general.link"),"text",true);

        $this->DataTableBuilder->setColumn("status",__("general.status"),function ($value){
            if($value==0)
                return "<span class='badge bg-label-warning'>غیرفعال</span>";
            elseif($value==1)
                return "<span class='badge bg-label-success'>فعال</span>";

        },true);
        $this->DataTableBuilder->setColumn("actions","",function($value,$model)
        {
            $data['buttons'][]=[
                "type"=>"link",
                "title"=>"ویرایش",
                "route"=>route('admin.app-settings.sliders.edit',$model->id),
                "attributes"=>[],
                "permission"=>"admin.app-settings.sliders.edit",
            ];
            $data['buttons'][]=[
                "type"=>"delete",
                "title"=>"حذف",
                "row_id"=>$model->id,
                "route"=>route('admin.app-settings.sliders.destroy',$model->id),
                "attributes"=>[],
                "permission"=>"admin.app-settings.sliders.destroy",
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
            __("general.add_slide"),
            route('admin.app-settings.sliders.create'),
            "btn-primary btn-icon-light",
            "bx bxs-user-plus",
            [],
            "admin.app-settings.sliders.create"
        );
    }

    public function filterColumn()
    {
        // CAST : INTEGER,float8,TEXT

        $this->DataTableBuilder->setFilterColumn("title","filter_title","text","%","col-md-3");
        $this->DataTableBuilder->setFilterColumn("link","filter_link","text","%","col-md-3");
    }
}
