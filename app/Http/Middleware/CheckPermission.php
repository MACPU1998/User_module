<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth("admin")->check())
        {
            $route_name = Route::currentRouteName();
            if(in_array($route_name,$this->whiteListRoutes()))
                return $next($request);
            else if(checkPermission($route_name))
                return $next($request);
            else
                abort(403);

        }
        return $next($request);
    }

    protected function whiteListRoutes()
    {
        return [
            "admin.dashboard",
            "admin.logout",
            "admin.login",
            "admin.getFile",
            "admin.loginProccess",
            "home",
            "admin.dropzone.upload.files",
        ];

    }
}
