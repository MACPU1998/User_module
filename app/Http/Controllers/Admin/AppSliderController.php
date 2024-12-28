<?php

namespace App\Http\Controllers\Admin;

use App\DataTableBuilders\AppSliderDataTableBuilder;
use App\DataTableBuilders\GoodDataTableBuilder;
use App\Enums\ActiveStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AppSliderCreate;
use App\Http\Requests\Admin\GiftshopProductUpdate;
use App\Models\AppSlider;
use App\Models\GiftShopProduct;
use Illuminate\Support\Facades\File;

class AppSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AppSliderDataTableBuilder $appSliderDataTableBuilder)
    {
        return view("admin.app-settings.sliders.index",compact('appSliderDataTableBuilder'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $status = ActiveStatus::toCollect();
        $status = generateObjectForComponent($status,"name","value");
        return view("admin.app-settings.sliders.create")->with(['status' => $status]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AppSliderCreate $appSliderCreate)
    {
        try {
            $slider = AppSlider::create($appSliderCreate->all());
            $slider->addMedia($appSliderCreate->media)->toMediaCollection('slider');
            return redirect()->route("admin.app-settings.sliders.index")->with("message",__("message.add_successfull"));
        }
        catch (\Exception $e){
            return back()->with("error",$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $product = GiftShopProduct::find($id);
        $status = ActiveStatus::toCollect();
        $status = generateObjectForComponent($status,"name","value");
        return view("admin.sale_partners.goods.edit")->with(['model' => $product, 'status' => $status]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GiftshopProductUpdate $giftshopProductUpdate, string $id)
    {
        //
        $product = GiftShopProduct::find($id);
        if($product){
            $data = $giftshopProductUpdate->all();
            if($giftshopProductUpdate->has("thumbnail")){
                $thumb = $giftshopProductUpdate->file('thumbnail');
                $fileName = $id.strtotime('now') . '.' . $thumb->extension();
                $fileDir = $thumb->storeAs('images/giftshopproducts', $fileName, ['disk' => 'public_uploads']);
                if(File::exists(public_path('assets/images/giftshopproducts/'.$product->thumbnail)))
                {
                    File::delete(public_path('assets/images/giftshopproducts/'.$product->thumbnail));
                }
                $data = array_merge($giftshopProductUpdate->all(),["thumbnail" => $fileName]);
            }
            $product->update(
               $data
            );
            return back()->with("message",__("message.update_successfull"));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        AppSlider::find($id)->delete();
        return redirect()->route("admin.app-settings.sliders.index")->with("message",__("message.remove_successfull"));

    }

    public function bulkDelete()
    {

    }
}
