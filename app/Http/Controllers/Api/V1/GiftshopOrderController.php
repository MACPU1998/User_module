<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\GiftShopOrder;
use Exception;
use Response;

class GiftshopOrderController extends ApiController
{
    public function orders()
    {
            $orders = GiftShopOrder::where("user_id",auth("salePartner")->user()->id)
                ->where("user_type",getUserType())
                ->orderBy('id', 'desc')->get();
            return Response::success(data: $orders);
    }

    public function order($id)
    {
        $order = GiftShopOrder::where("id",$id)->where("user_id",auth("salePartner")->user()->id)
            ->where("user_type",getUserType())
            ->first();
        if($order)
            return Response::success(data: $order);
        else
            return Response::error(
                code: 500,
                message: "این آیتم یافت نشد!"
            );
    }
}
