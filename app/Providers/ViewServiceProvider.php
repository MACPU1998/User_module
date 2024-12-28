<?php

namespace App\Providers;

use App\View\Composers\DefaultComposer;
use App\View\Composers\SidebarComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer("admin.layout.sidebar",SidebarComposer::class);
        View::composer("admin.*",DefaultComposer::class);
    }
}
