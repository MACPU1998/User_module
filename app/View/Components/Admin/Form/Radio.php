<?php

namespace App\View\Components\Admin\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Radio extends Component
{
    public $sectionClass;
    public $label;
    public $id;
    public $name;
    public $required;
    public $class;
    public $items;
    public $selectedItem;
    public $hint;
    public $translate;
    /**
     * Create a new component instance.
     */
    public function __construct($sectionClass="col-md-12",$label=null,$id=null,$name=null,$required=false,$class=null,$items=null,$selectedItem=null,$hint=null,$translate=false)
    {
        $this->sectionClass=$sectionClass;
        $this->label=$label;
        $this->id=$id;
        $this->name=$name;
        $this->required=$required;
        $this->class=$class;
        $this->items=$items;
        $this->selectedItem=$selectedItem;
        $this->hint=$hint;
        $this->translate=$translate;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.form.radio');
    }
}