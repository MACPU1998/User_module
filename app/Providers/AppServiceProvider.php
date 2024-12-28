<?php

namespace App\Providers;

use App\Enums\SystemMessage;
use App\Models\Admin\Setting;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Response as HttpFoundation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (env('APP_ENV') !== 'local') { //so you can work on it locally
            URL::forceScheme('https');
        }
        $this->registerResponseMacros();

        Schema::defaultStringLength(191);
        Paginator::useBootstrapFive();
        //$this->getSettings();

    }

    public function getSettings()
    {
        Cache::rememberForever('settings_results', function () {
            return Setting::all();
        });

    }
    private function registerResponseMacros(): void
    {
        Response::macro('success', fn($code = SystemMessage::SUCCESS, $message = null, $data = [], $http_status = HttpFoundation::HTTP_OK) => Response::make([
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ], $http_status));

        Response::macro('store', fn($message = null, $data = []) => Response::success(SystemMessage::SUCCESS, $message ?? __("It was created successfully."), $data, HttpFoundation::HTTP_CREATED));

        Response::macro('update', fn($message = null, $data = []) => Response::success(SystemMessage::SUCCESS, $message ?? __("Successfully updated."), $data, HttpFoundation::HTTP_ACCEPTED));

        Response::macro('destroy', fn($message = null) => Response::success(SystemMessage::SUCCESS, $message ?? __('Removed successfully.'), [], HttpFoundation::HTTP_ACCEPTED));

        Response::macro('error', fn($code, $message, $errors = [], $http_status = HttpFoundation::HTTP_BAD_REQUEST) => Response::make([
            'code' => $code,
            'message' => $message,
            'errors' => (object)$errors
        ], $http_status));

        Response::macro('dataNotFound', fn($errors = []) => Response::error(SystemMessage::DATA_NOT_FOUND, $message = __('Not found.'), $errors, HttpFoundation::HTTP_NOT_FOUND));

        Response::macro('forbidden', fn($code, $message, $errors = []) => Response::error($code, $message, $errors, HttpFoundation::HTTP_FORBIDDEN));

        Response::macro('badGateway', fn($code, $message, $errors = []) => Response::error($code, $message, $errors, HttpFoundation::HTTP_BAD_GATEWAY));
    }
}
