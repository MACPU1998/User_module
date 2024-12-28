<?php

namespace App\Http\Middleware\Api;

use App\Enums\UserStatus;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->check())
        {
            if(auth()->user()->status == UserStatus::BANNED->value || auth()->user()->deleted_at != null)
            {
                return FacadesResponse::json([
                    "success"=>false,
                    "code" => 109,
                    "errors"=>[
                        "message"=>["لطفا وارد حساب کاربری خود شوید!"]
                    ]
                ], 403);

            }
        }
        return $next($request);
    }
}
