<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Good;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Response;

class GoodShopController extends ApiController
{
    public function goods()
    {
        $goods = Good::where("status",1)->get();
        return Response::success(data: $goods);
    }

    public function good($id)
    {
        $good = Good::where("id",$id)->where("status",1)->first();
        if($good)
            return Response::success(data: $good);
        else
            return Response::error(
                code: 404,
                message: "یافت نشد!"
            );
    }

    /**
     * add or update goods to cart
     * @param int $id
     * @param int $quantity
     * @return void
     */
    public function addToCart(int $id, int $quantity)
    {
        $user = auth("salePartner")->user();
        $cart = Order::where("status",0)->where("sale_partner_id",$user->id)->first();
        try {
            DB::beginTransaction();
            //find good
            $good = Good::find($id);
            if (!$good)
                return Response::error(
                    code: 404,
                    message: "The good not found!"
                );
            if ($cart) {
                $cartGood = $cart->goods?->where("good_id", $id)->first();
                if ($cartGood)
                    $cartGood->update([
                        "quantity" => $cartGood->quantity + $quantity
                    ]);
                else
                    $cartGood = OrderItem::create([
                        "order_id" => $cart->id,
                        "good_id" => $good->id,
                        "quantity" => $quantity
                    ]);
            } else {
                $cart = Order::create([
                    "sale_partner_id" => $user->id,
                    "status" => 0 // consider as cart or partial order
                ]);
                $cartGood = OrderItem::create([
                    "order_id" => $cart->id,
                    "good_id" => $good->id,
                    "quantity" => $quantity
                ]);
            }
            DB::commit();
            return Response::success(data: $cart);
        }
        catch (\Exception $exception){
            DB::rollBack();
            return Response::error(
                code: 500,
                message: $exception->getMessage()
            );
        }
    }

    /**
     * get active cart
     * @return void
     */
    public function getCart()
    {
        $user = auth("salePartner")->user();
        $cart = Order::where("status",0)->where("sale_partner_id",$user->id)->first();
        try {
            //find cart
            if ($cart)
                return Response::success(data: $cart);
            else
                return Response::error(
                code: 404,
                message: "سبد سفارش خالی است!"
            );
        }
        catch (\Exception $exception){
            return Response::error(
                code: 500,
                message: $exception->getMessage()
            );
        }
    }


}
