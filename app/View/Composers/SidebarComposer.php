<?php

namespace App\View\Composers;

use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;

class SidebarComposer
{
    public function compose(View $view)
    {
        // Fetch the data you want to share with the view
        $sidebar_menus = Permission::where("active",true)->where("in_sidebar",true)->get()->toArray(); // Replace with your actual data retrieval logic
        $current_routename=Route::currentRouteName();
        // Share the data with the view
        $view->with('sidebar_menus', buildTree($sidebar_menus,"parent"));
        $view->with('current_routename', $current_routename);
    }
}
