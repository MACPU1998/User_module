<?php
namespace App\Services\Api\DataTableBuilder;


abstract class AbstractDataTableBuilder
{
    public $query;
    abstract function columns();
    abstract function toolbar();
    abstract function filterColumn();
    abstract function setMultiselect();
    public $DataTableBuilder;

    public function __construct()
    {
        $this->DataTableBuilder=new DataTableBuilder();
        $this->init();
    }

    public function init()
    {
        $this->query=app($this->model)::query();
        $this->DataTableBuilder->setTableName($this->tableName);
        $this->DataTableBuilder->setQuery($this->query);
    }

    public function render()
    {
        $this->columns();
        $this->toolbar();
        $this->setMultiselect();
        $this->filterColumn();
    }

    public function lastQuery()
    {
        return $this->DataTableBuilder->lastQuery();
    }

    public function initQuery()
    {
        return $this->DataTableBuilder->initQuery();
    }

    public function filter($callback)
    {
        $this->DataTableBuilder->filter($callback);
        return $this;
    }

    public function table()
    {
        $this->render();
        return $this->DataTableBuilder->generate();
    }
    public function query(){
        return $this->query;
    }
}
