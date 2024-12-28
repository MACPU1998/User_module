<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\CoinWalletTransaction;
use App\Models\GiftShopOrder;
use App\Models\GiftShopProduct;
use Illuminate\Support\Facades\DB;
use Response;

class GiftshopProductController extends ApiController
{
    public function products()
    {
        $products = GiftShopProduct::where("status",1)
            ->whereIn("user_type",[0, getUserType()])->get();
        return Response::success(data: $products);
    }

    public function product($id)
    {
        $product = GiftShopProduct::where("id",$id)->where("status",1)
            ->whereIn("user_type",[0, getUserType()])->first();
        if($product)
            return Response::success(data: $product);
        else
            return Response::error(
                code: 500,
                message: "یافت نشد!"
            );
    }

    public function purchase($id)
    {
        $product = GiftShopProduct::where("id",$id)->where("status",1)
            ->whereIn("user_type",[0, getUserType()])->first();
        $user = auth()->user();
        if($product->stock>0){
            if(auth()->user()->walletable->balance < $product->cost_value)
                return Response::error(
                    code: 500,
                    message: "میزان سکه شما برای خرید این آیتم کافی نیست!"
                );
            try{
                DB::beginTransaction();
                $user = auth()->user();
                $product->update([
                    "stock" => $product->stock-1,
                ]);
                $order = GiftShopOrder::create([
                    "user_id" => auth()->user()->id,
                    "user_type" => getUserType(),
                    "giftshop_product_id" => $product->id,
                    "quantity" => 1,
                    "status" => true,
                    "cost_type" => $product->cost_type,
                    "cost_value" => $product->cost_value
                ]);
                $user->walletable->update([
                    "balance" => auth()->user()->walletable->balance - $product->cost_value
                ]);
                CoinWalletTransaction::create([
                   "from_wallet_id"=> auth()->user()->walletable->id,
                    "to_wallet_id"=> 0,
                    "amount" => $product->cost_value
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
        else
            return Response::error(
                code: 500,
                message: "این آیتم موجود نیست!"
            );
    }
}
