<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
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
        Blade::directive('checkHasPermission', function ($expression) {
            // Parse the expression to get the permission and optional arguments.
            $parsedExpression = Blade::stripParentheses($expression);
            $permission = trim($parsedExpression);

            // Build the custom logic for your permission check.
            return "<?php if(checkPermission({$permission})) : ?>";
        });

        Blade::directive('endcheckHasPermission', function () {
            return '<?php endif; ?>';
        });
    }
}
