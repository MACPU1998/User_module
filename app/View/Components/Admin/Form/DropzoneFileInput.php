<?php

namespace App\View\Components\Admin\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DropzoneFileInput extends Component
{
    public $sectionClass;
    public $label;
    public $id;
    public $name;
    public $required;
    public $class;
    public $value;
    public $hint;
    public $preview;
    public $maxFileSize;
    public $allowFileExtensions;
    public $storeUrl;
    public $deleteUrl;
    /**
     * Create a new component instance.
     */
    public function __construct($sectionClass="col-md-12",$label=null,$id=null,$name=null,$required=false,$class=null,$value=null,$hint=null,$preview=null,$maxFileSize=2,$allowFileExtensions="jpg,jpeg,png", $storeUrl=null,$deleteUrl=null)
    {
        $this->sectionClass=$sectionClass;
        $this->label=$label;
        $this->id=$id;
        $this->name=$name;
        $this->required=$required;
        $this->class=$class;
        $this->value=$value;
        $this->hint=$hint;
        $this->preview=$preview;
        $this->maxFileSize=$maxFileSize;
        $this->allowFileExtensions=$allowFileExtensions;
        $this->storeUrl=$storeUrl;
        $this->deleteUrl=$deleteUrl;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.form.dropzone-file-input');
    }
}
