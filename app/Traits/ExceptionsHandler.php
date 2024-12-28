<?php

namespace App\Traits;

use App\Enums\SystemMessage;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\Log;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as HttpFoundation;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait ExceptionsHandler
{
    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param \Throwable $e
     * @return \Illuminate\Http\Response
     *
     * @throws \Throwable
     */
    public function render($request, \Throwable $e): \Illuminate\Http\Response
    {
        // checking exception for api
        if (!$this->isApi($request)) {
            return parent::render($request, $e);
        }

        Log::error($e);

        if ($e instanceof NotFoundHttpException) {
            return Response::error(
                code: SystemMessage::PAGE_NOT_FOUND,
                message: __('Not Found'),
                http_status: HttpFoundation::HTTP_NOT_FOUND
            );
        }

        if ($e instanceof AuthorizationException) {

            return Response::error(
                code: SystemMessage::FAIL,
                message: $e->getMessage(),
                http_status: HttpFoundation::HTTP_FORBIDDEN
            );

        }

        if ($e instanceof ModelNotFoundException) {
            return Response::error(
                code: SystemMessage::DATA_NOT_FOUND,
                message: __('Not Found'),
                http_status: HttpFoundation::HTTP_NOT_FOUND
            );
        }

        if ($e instanceof ValidationException) {
            return Response::error(
                code: SystemMessage::BAD_DATA,
                message: __("The data(s) is invalid."),
                errors: $e->errors(),
                http_status: HttpFoundation::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        if (
            $e instanceof ThrottleRequestsException ||
            ($e instanceof HttpResponseException && $e->getResponse()->getStatusCode() == HttpFoundation::HTTP_TOO_MANY_REQUESTS)
        ) {
            return Response::error(
                code: SystemMessage::FAIL,
                message: __($e->getMessage()),
                http_status: HttpFoundation::HTTP_TOO_MANY_REQUESTS
            );
        }

        if ($e instanceof AuthenticationException) {
            return Response::error(
                code: SystemMessage::FAIL,
                message: __($e->getMessage()),
                http_status: HttpFoundation::HTTP_UNAUTHORIZED
            );
        }

        if (env('APP_DEBUG', false)) {
            return Response::error(
                code: SystemMessage::INTERNAL_ERROR,
                message: __($e->getMessage()),
                http_status: HttpFoundation::HTTP_INTERNAL_SERVER_ERROR
            );
        } else {
            return Response::error(
                code: SystemMessage::INTERNAL_ERROR,
                message: __('Server Error'),
                http_status: HttpFoundation::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    private function isApi($request): bool
    {
        if (
            str_contains($request->url(), '/api') ||
            str_contains($request->getHost(), 'api')
        ) {
            return true;
        }

        return false;
    }
}
