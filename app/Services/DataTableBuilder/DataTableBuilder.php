<?php
namespace App\Services\Api\DataTableBuilder;

use Exception;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Facades\Storage;


class DataTableBuilder
{
    protected $tableName;
    protected $multiselect;
    protected $multiselectButtons=[];
    protected $multiselectButtonsData=[];
    protected $headers;
    protected $sortableFields;
    protected $columns;
    protected $mergeColumns;
    protected $toolbar;
    protected $data;
    protected $query;
    protected $paginate;
    protected $paginateSizes = [];
    protected $lastQuery;
    protected $filterColumns=[];
    protected $toolbarButtons=[];
    protected $valid_types = ["image","integer","boolean","text","callable"];
    protected $sortRelations=[];
    public function setTableName($tableName)
    {
        $this->tableName=$tableName;
    }
    public function setMultiSelectStatus($multiselect)
    {
        $this->multiselect=$multiselect;
    }
    public function setMultiSelectButton(string $button_name,string $title, string $route=null,string $class=null, string $icon=null, array $attributes=[],$permission=null)
    {
        $this->multiselectButtons[] = [
            "button_name" => $button_name,
            "title" => $title,
            "route" => $route,
            "class" => $class,
            "icon" => $icon,
            "attributes" => $attributes,
            "permission" =>$permission
        ];
    }
    public function setMultiSelectButtonData(string $button_name,string $data_button_name, string $title, $value, string $icon=null, array $attributes=[],$permission=null)
    {
        $this->multiselectButtonsData[$button_name][]=["button_name"=>$data_button_name,"title"=>$title,"value"=>$value,"icon"=>$icon,"attributes"=>$attributes,"permission"=>$permission];
    }
    public function setQuery($query)
    {
        if(!($query instanceof EloquentBuilder))
            throw new Exception("data must be instanceOf Eloquentbuilder", 1);
        $this->query=$query;
        return $this;
    }

    public function setToolbar($toolbar)
    {
        $this->toolbar = $toolbar;
    }

    public function setColumn(string $column,string $label=null,$type="text",bool $sortable=false,$sortableCast=null,$columnStyle=null)
    {
        $relation = null;
        if(str_contains($column, ":"))
        {
            list($col,$rel)=explode(":",$column);
            $this->sortRelations[$col]=$rel;
            $relation = $rel;
        }
        else
        {
            $col=$column;
        }
        $label=($label)??$col;

        $column_array=["column"=>$col,"label"=>$label,"type"=>$type,"sortable"=>$sortable,"sortableCast"=>$sortableCast,"columnStyle" => $columnStyle,"relation"=> $relation];
        $this->columns[]=$column_array;
        return $this;
    }

    public function mergeColumn(string $parentColumn,string $localColumn,string $label=null,$type="text",bool $sortable=false,$sortableCast=null,$columnStyle=null)
    {
        $column_array=["column"=>$localColumn,"label"=>$label,"type"=>$type,"sortable"=>$sortable,"sortableCast"=>$sortableCast,"columnStyle" => $columnStyle];
        $this->mergeColumns[$parentColumn][]=$column_array;

        return $this;
    }

    public function setPaginate(int $perPage){
        $this->paginate = $perPage;
    }

    public function setPaginateSizes(array $sizes = []){
        $this->paginateSizes = $sizes;
    }



    public function setFilterColumn($columnName,$elementName,$elemntType,$filterType="=",$class="col-md-3",$data=null,$cast=null)
    {
        $fiter_columns_array=["columnName"=>$columnName,"elementName"=>$elementName,"elementType"=>$elemntType,"filterType"=>$filterType,"data"=>$data,"cast"=>$cast,"class"=>$class];
        $this->filterColumns[]=$fiter_columns_array;

    }

    public function filter($callback)
    {
        if(!is_callable($callback))
            throw new Exception("Input Argument of Filter method is not Callable");
        $this->query=$this->query->where(call_user_func($callback,$this->query));
        return $this;

    }

    public function setToolButton(string $title, string $route=null, string $class=null, string $icon=null, array $attributes=[],$permission=null)
    {
        $this->toolbarButtons[] = [
            "title" => $title,
            "route" => $route,
            "class" => $class,
            "icon" => $icon,
            "attributes" => $attributes,
            "permission" =>$permission
        ];
    }




    protected function generateValidColumns($columns)
    {
        $final_columns=[];
        foreach($columns as $column)
        {
            if(!multi_dim($column))
            {
                if(!in_array($this->originalType($column['type']),$this->valid_types) && !is_callable($column['type']))
                    throw new Exception($column['type'] ." Not Valid Type For Column", 1);
            }
            else
            {
                foreach($column as $subcolumn)
                {
                    if(!in_array($this->originalType($subcolumn['type']),$this->valid_types) && !is_callable($subcolumn['type']))
                    throw new Exception($subcolumn['type'] ." Not Valid Type For Column", 1);
                }
            }
        }

        foreach($columns as $column)
        {
            if(isset($this->mergeColumns[$column['column']]) && count($this->mergeColumns[$column['column']]) > 0)
            {
                $totalColumn[]=$column;
                $column=array_merge($totalColumn,$this->mergeColumns[$column['column']]);
            }
            $final_columns[]=$column;
        }
        return $final_columns;
    }

    private function originalType($type)
    {
        if(!is_callable($type))
        {
            $type=explode(":",$type,2)[0];
            return  $type;
        }
        return"callable";
    }


    protected function tableQuery($query)
    {
        if(session()->has($this->tableName."_sort"))
        {
            foreach(session($this->tableName."_sort") as $key=>$sort)
            {
                $sort_column=$key;
                $sort_type=$sort;
                $column = array_column($this->columns, "column");
                $found_key = array_search($sort_column, $column);
                if($this->columns[$found_key]['sortableCast'])
                    if(isset($this->sortRelations[$sort_column]))
                        $query=$query->with([$this->sortRelations[$sort_column]=>function($q) use($sort_column,$found_key,$sort_type){
                            $q->orderByRaw("CAST(".$sort_column." AS ".$this->columns[$found_key]['sortableCast'].") ".$sort_type);
                        }]);
                    else
                        $query=$query->orderByRaw("CAST(".$sort_column." AS ".$this->columns[$found_key]['sortableCast'].") ".$sort_type);
                else
                    if(isset($this->sortRelations[$sort_column])){
                        $query=$query->with($this->sortRelations[$sort_column])->orderBy("coin_wallets.".$sort_column,$sort_type);
                        dump($this->query->toSql());
                    }
                    else
                        $query=$query->orderBy($sort_column,$sort_type);
            }
        }
        else
        {
            $query=$query->orderBy("id","desc");
        }

        $this->query=$query->where(function($q){
            foreach($this->filterColumns as $filterColumn)
            {
                if(!in_array($filterColumn['elementType'],["range:text","range:select","range:date","range:numeric"]))
                {
                    $q->when(isset(session($this->tableName."_filter")[$filterColumn['elementName']]),function($q) use($filterColumn){
                        $columnName=null;
                        $relName=null;
                        if(strpos($filterColumn['columnName'],":") !== false)
                        {
                            list($columnName,$relName)=explode(":",$filterColumn['columnName']);
                        }
                        else
                        {
                            $columnName=$filterColumn['columnName'];
                        }

                        if($filterColumn['filterType'] == "=")
                        {
                            if($filterColumn['cast'])
                            {
                                if($relName)
                                    $q->whereHas($relName,function($query) use($columnName,$filterColumn){
                                        $query->whereRaw("CAST(".$columnName." AS ".$filterColumn['cast'].") = ? ",[session($this->tableName."_filter")[$filterColumn['elementName']]]);
                                    });
                                else
                                    $q->whereRaw("CAST(".$columnName." AS ".$filterColumn['cast'].") = ? ",[session($this->tableName."_filter")[$filterColumn['elementName']]]);
                            }
                            else
                            {
                                if($relName)
                                    $q->whereHas($relName,function($query) use($columnName,$filterColumn){
                                        $query->where($columnName,session($this->tableName."_filter")[$filterColumn['elementName']]);
                                    });
                                else
                                    $q->where($columnName,session($this->tableName."_filter")[$filterColumn['elementName']]);
                            }
                        }
                        elseif($filterColumn['filterType'] == "%")
                        {
                            if($relName)
                                $q->whereHas($relName,function($query) use($columnName,$filterColumn){
                                    $query->where($columnName,"like","%".session($this->tableName."_filter")[$filterColumn['elementName']]."%");
                                });
                            else
                                $q->where($columnName,"like","%".session($this->tableName."_filter")[$filterColumn['elementName']]."%");
                        }
                    });

                }
                else
                {
                    $q->when(isset(session($this->tableName."_filter")[$filterColumn['elementName'][0]]),function($q) use($filterColumn){
                        if($filterColumn['cast'])
                        {
                            $q->whereRaw("CAST(".$filterColumn['columnName']." AS ".$filterColumn['cast'].") >= ? ",[session($this->tableName."_filter")[$filterColumn['elementName'][0]]]);

                        }
                        else
                        {
                            $q->where($filterColumn['columnName'],">=",session($this->tableName."_filter")[$filterColumn['elementName'][0]]);

                        }
                    });
                    $q->when(isset(session($this->tableName."_filter")[$filterColumn['elementName'][1]]),function($q) use($filterColumn){
                        if($filterColumn['cast'])
                        {
                            $q->whereRaw("CAST(".$filterColumn['columnName']." AS ".$filterColumn['cast'].") <= ? ",[session($this->tableName."_filter")[$filterColumn['elementName'][1]]]);
                        }
                        else
                        {
                            $q->where($filterColumn['columnName'],"<=",session($this->tableName."_filter")[$filterColumn['elementName'][1]]);

                        }
                    });
                    // $from=$filterColumn['elementName'][0];
                    // $=$filterColumn['elementName'][1];

                }

            }
        });


        return $this->query;
    }

    public function tableData($query)
    {
        //$query->orderBy("id","DESC");
        if(count($this->paginateSizes)>0){
            $pageSize = (count($this->paginateSizes)>0 && isset(session($this->tableName."_paginate")["perPage"]))?session($this->tableName."_paginate")["perPage"]:$this->paginateSizes[0];

            return $query->paginate($pageSize);

        }elseif ($this->paginate>0){
            //dd()
            return $query->paginate($this->paginate);
        }
        else
            return $query->paginate(50);
    }

    public function lastQuery()
    {
        return $this->tableQuery($this->query);
    }

    public function initQuery()
    {
        return $this->query;
    }

    public function generate()
    {
        $data['tableName']=$this->tableName;
        $data['multiselect']=$this->multiselect;
        $data['multiselectButtons']=$this->multiselectButtons;
        checkFilter($this->tableName);
        $data['data']=$this->tableData($this->tableQuery($this->query));
        $data['headers']=$this->headers;
        $data['columns']=$this->generateValidColumns($this->columns);
        $data['filterColumns']=$this->filterColumns;
        $data['toolbarButtons']=$this->toolbarButtons;
        $data["paginateSection"]=$this->paginate();
        $data["filterSection"]=$this->filterSection();
        $data["toolbarSection"]=$this->toolbar();
        return view("admin.vendor.table.default",$data)->render();
    }

    public function toolbar()
    {
        $data['tableName']=$this->tableName;
        $data["paginateSizes"]=$this->paginateSizes;
        $data['toolbarButtons']=$this->toolbarButtons;
        $data['multiselect']=$this->multiselect;
        $data['multiselectButtons']=$this->multiselectButtons;
        $data['multiselectButtonsData']=$this->multiselectButtonsData;
        return view("admin.vendor.table.toolbar",$data)->render();
    }

    public function paginate()
    {
        $data['tableName']=$this->tableName;
        $data["paginateSizes"]=$this->paginateSizes;
        return view("admin.vendor.table.paginate",$data)->render();
    }

    public function filterSection()
    {
        $data['filterColumns']=$this->filterColumns;
        $data['tableName']=$this->tableName;
        return view("admin.vendor.table.filter",$data)->render();
    }

    public function columnData($value, $type, $model)
    {
        if(is_callable($type))
            return call_user_func($type,$value,$model);
        elseif($this->originalType($type) == "image")
        {
            list($type,$features)=explode(":",$type,2);
            $featuresArray=explode("|",$features);
            $path=$featuresArray[0];
            $disk=isset($featuresArray[1]) ? $featuresArray[1] :  "public";
            $secureMode=isset($featuresArray[2]) && $featuresArray[2] == "secure" ? true : false;
            if($disk != "sftp" && (!isset($path) || !$path))
                throw new Exception("Invalid type of ".$type);

            if($secureMode)
            {

            }
            return "<img width='64' src='".asset($path."/".$value)."' class='rounded-3 w-60px h-60px'/>";
        }
            return $value;
    }
}
