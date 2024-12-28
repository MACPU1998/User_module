<?php

use App\Services\Api\DataTableBuilder\Controllers\DataTableController;
use Illuminate\Support\Facades\Route;

Route::name("")->group(function(){
    Route::get("/table/{table}/sort/{column}",[DataTableController::class,"sort"])->name("sort_table")->withoutMiddleware("CheckPermission");
    Route::post("/table/{table}/filter",[DataTableController::class,"filter"])->name("filter_table")->withoutMiddleware("CheckPermission");
    Route::get("/table/{table}/remove-filter",[DataTableController::class,"removeFilter"])->name("remove_filter")->withoutMiddleware("CheckPermission");
    Route::post("/table/{table}/set-page",[DataTableController::class,"setPage"])->name("set_page")->withoutMiddleware("CheckPermission");
 });
