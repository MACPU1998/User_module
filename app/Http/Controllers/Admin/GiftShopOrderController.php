<?php

namespace App\Http\Controllers\Admin;

use App\DataTableBuilders\GiftShopOrderDataTableBuilder;
use App\DataTableBuilders\GoodDataTableBuilder;
use App\Enums\ActiveStatus;
use App\Enums\OrderStatus;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GiftshopOrderUpdate;
use App\Http\Requests\Admin\GiftshopProductCreate;
use App\Http\Requests\Admin\GiftshopProductUpdate;
use App\Models\GiftShopOrder;
use App\Models\GiftShopProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GiftShopOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GiftShopOrderDataTableBuilder $giftShopOrderDataTableBuilder)
    {
        $giftShopOrderDataTableBuilder->query()->where("user_type",1);
        return view("admin.gift_shop_orders.index",compact('giftShopOrderDataTableBuilder'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GiftshopProductCreate $giftshopProductCreate)
    {

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
        $order = GiftShopOrder::find($id);
        $user = $order->userable;
        $status = OrderStatus::toCollect();
        $status = generateObjectForComponent($status,"name","value");
        return view("admin.gift_shop_orders.edit")->with(['model' => $order,"user" => $user, 'status' => $status]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GiftshopOrderUpdate $giftshopOrderUpdate, string $id)
    {
        //
        $order = GiftShopOrder::find($id);
        if($order){
            $order->update(
                $giftshopOrderUpdate->all()
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