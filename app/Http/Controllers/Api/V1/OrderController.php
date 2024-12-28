<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\SubmitOrder;
use App\Models\Good;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\DB;
use Response;

class OrderController extends ApiController
{
    public function orders()
    {
        $orders = Order::where("sale_partner_id",auth("salePartner")->user()->id)->with("goods")->get();
        return Response::success(data: $orders);
    }

    public function order($id)
    {
        $order = Order::where("sale_partner_id",auth("salePartner")->user()->id)
            ->where("id",$id)->with("goods")->first();
        if($order)
            return Response::success(data: $order);
        else
            return Response::error(
                code: 404,
                message: "یافت نشد!"
            );
    }

    /**
     * submit active order from app
     * @return void
     */
    public function submitOrder(SubmitOrder $request)
    {
        $user = auth("salePartner")->user();
        try {
            DB::beginTransaction();
            $order = Order::create([
                "code" => date("ymds").rand(1000,9999),
                "sale_partner_id" => $user->id,
                "status" => 1, // consider pending order
                "description" => $request->description
            ]);
            foreach ($request->final_items as $item)
                $cartGood = OrderItem::create([
                    "order_id" => $order->id,
                    "good_id" => $item["product_id"],
                    "quantity" => $item["quantity"]
                ]);
            DB::commit();
            return Response::success(data: $order);

        }
        catch (\Exception $exception){
            DB::rollBack();
            return Response::error(
                code: 500,
                message: $exception->getMessage()
            );
        }
    }
}
