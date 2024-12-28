<?php

namespace App\Http\Controllers\Admin;

use App\DataTableBuilders\GiftShopProductDataTableBuilder;
use App\DataTableBuilders\GoodDataTableBuilder;
use App\Enums\ActiveStatus;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GiftshopProductCreate;
use App\Http\Requests\Admin\GiftshopProductUpdate;
use App\Models\GiftShopProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GiftShopProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GiftShopProductDataTableBuilder $giftShopProductDataTable)
    {
        return view("admin.gift_shop_product.index",compact('giftShopProductDataTable'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $status = ActiveStatus::toCollect();
        $status = generateObjectForComponent($status,"name","value");
        return view("admin.gift_shop_product.create")->with(['status' => $status]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GiftshopProductCreate $giftshopProductCreate)
    {
        $thumb = $giftshopProductCreate->file('thumbnail');
        $fileName = random_int(1234,9999).strtotime('now') . '.' . $thumb->extension();
        $fileDir = $thumb->storeAs('images/giftshopproducts', $fileName, ['disk' => 'public_uploads']);
        $data = array_merge($giftshopProductCreate->all(),["thumbnail" => $fileName,"cost_type"=>2]);
        GiftShopProduct::create($data);
            return redirect()->route("user.users_management.giftshop_products.index")->with("message",__("message.add_successfull"));
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
        return view("admin.gift_shop_product.edit")->with(['model' => $product, 'status' => $status]);
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
        GiftShopProduct::find($id)->delete();
        return redirect()->route("user.users_management.giftshop_products.index")->with("message",__("message.remove_successfull"));

    }

    public function bulkDelete()
    {

    }
}
