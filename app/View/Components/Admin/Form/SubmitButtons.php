<?php

namespace App\View\Components\Admin\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SubmitButtons extends Component
{
    public $reset;

    public $sectionClass;
    /**
     * Create a new component instance.
     */
    public function __construct($reset=false,$sectionClass="")
    {
        $this->reset=$reset;
        $this->sectionClass=$sectionClass;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.form.submit-buttons');
    }
}
