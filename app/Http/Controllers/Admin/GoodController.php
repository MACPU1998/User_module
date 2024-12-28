<?php

namespace App\Http\Controllers\Admin;

use App\DataTableBuilders\GoodDataTableBuilder;
use App\Enums\ActiveStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GoodCreate;
use App\Http\Requests\Admin\GoodUpdate;
use App\Models\Good;

class GoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GoodDataTableBuilder $goodDataTable)
    {
        return view("admin.sale_partners.goods.index",compact('goodDataTable'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $status = ActiveStatus::toCollect();
        $status = generateObjectForComponent($status,"name","value");
        return view("admin.sale_partners.goods.create")->with(['status' => $status]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GoodCreate $request)
    {
        try {
            $good = Good::create($request->all());


            if($request->has("images"))
                dropzoneStoreFiles($good,"images","goods");

            return redirect()->route("admin.sale_partners_management.goods.index")->with("message",__("message.add_successfull"));
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
        $product = Good::find($id);
        $status = ActiveStatus::toCollect();
        $status = generateObjectForComponent($status,"name","value");
        $productImages = $product->getMedia("goods")->toArray();
        return view("admin.sale_partners.goods.edit")->with(['model' => $product, 'status' => $status,"productImages"=>$productImages]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GoodUpdate $request, string $id)
    {
        //
        $product = Good::find($id);
        if($product){
            $data = $request->all();
            $product->update(
               $data
            );
            if($request->has("images"))
                dropzoneUpdateFiles($product,"images","goods");
            return back()->with("message",__("message.update_successfull"));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $good = Good::find($id);
        dropzoneDeleteFiles($good,"goods");
        $good->delete();
        return redirect(route("admin.sale_partners_management.goods.index"))->with("message",__("message.remove_successfull"));

    }

    public function bulkDelete()
    {

    }
}
