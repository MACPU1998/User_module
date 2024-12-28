<?php

namespace App\Http\Controllers\Admin;

use App\DataTableBuilders\GoodDataTableBuilder;
use App\DataTableBuilders\OrderDataTableBuilder;
use App\Enums\ActiveStatus;
use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GiftshopProductUpdate;
use App\Http\Requests\Admin\GoodCreate;
use App\Http\Requests\Admin\OrderUpdate;
use App\Models\GiftShopProduct;
use App\Models\Good;
use App\Models\Order;
use Illuminate\Support\Facades\File;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(OrderDataTableBuilder $orderDataTable)
    {
        return view("admin.sale_partners.orders.index",compact('orderDataTable'));
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
    public function store(GoodCreate $goodCreate)
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
        $order = Order::find($id);
        $status = OrderStatus::toCollect();
        $status = generateObjectForComponent($status,"name","value");
        return view("admin.sale_partners.orders.edit")->with(['model' => $order, 'status' => $status]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderUpdate $orderUpdate, string $id)
    {
        //
        $order = Order::find($id);
        if($order){
            $data = $orderUpdate->all();

            $order->update(
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
        Order::find($id)->delete();
        return redirect()->route("admin.sale_partners.orders.index")->with("message",__("message.remove_successfull"));

    }
}
