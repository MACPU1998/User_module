<?php

namespace App\Providers;

use App\Services\Api\DataTableBuilder\DataTableBuilder;

use Illuminate\Support\ServiceProvider;

class FacadesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        app()->bind("DataTableBuilder",function(){
            return new DataTableBuilder;
        });
    }
}
