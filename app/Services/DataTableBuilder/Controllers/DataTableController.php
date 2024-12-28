<?php

namespace App\Services\Api\DataTableBuilder\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DataTableController extends Controller
{
    public function sort($table,$column)
    {
        if(!isset(session($table."_sort")[$column]))
            session([$table."_sort"=>[$column=>"desc"]]);
        else if(isset(session($table."_sort")[$column]))
        {
            if(session($table."_sort")[$column]=="desc")
            {
                $sort_type="asc";
                session([$table."_sort"=>[$column=>$sort_type]]);
            }
            else
                session()->remove($table."_sort")[$column];
        }
        return back();
    }

    public function filter(Request $request,$table)
    {
        $filters=$request->except('_token');
        $resultArray=[];
        foreach ($filters as $key=>$filter) {
            if ($filter !== null) {
                if(strpos($key,"filterdate_") === 0)
                {
                    $key = str_replace("filterdate_","",$key);
                    if(strpos($key,"filter_from") !==false)
                        $resultArray[$key] = date("Y-m-d 00:00:00",shamsiToTime(numberToEnglish($filter),"-"));
                    elseif(strpos($key,"filter_to") !==false)
                        $resultArray[$key] = date("Y-m-d 23:59:59",shamsiToTime(numberToEnglish($filter),"-"));
                }
                else
                    $resultArray[$key] = $filter;
            }
        }
        $filters=$resultArray;
        session([$table."_filter"=>$filters]);
        session(["hasFilter"=>true]);
        return back();
    }

    public function removeFilter($table)
    {
        session()->forget($table."_filter");
        return back();
    }

    public function setPage(Request $request, $table){
        if(!isset(session($table."_paginate")["perPage"]))
            session([$table."_paginate"=>["perPage"=>$request->size]]);
        else
            session([$table."_paginate"=>["perPage"=>$request->size]]);

        return back();
    }


}
