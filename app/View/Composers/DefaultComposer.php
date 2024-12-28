<?php

namespace App\View\Composers;

use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;

class DefaultComposer
{
    public function compose(View $view)
    {
        // Fetch the data you want to share with the view

        $activeStatus = generateObjectForComponent(\App\Enums\ActiveStatus::toCollect(),"name","value");

        // Share the data with the view
        $view->with('activeStatus', $activeStatus);
    }
}
