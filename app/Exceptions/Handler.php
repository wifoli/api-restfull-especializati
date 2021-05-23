<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof NotFoundHttpException)
            if ($request->expectsJson())
                return response()->json(['erro' => 'Not_found_URI'], $e->getStatusCode());

        if ($e instanceof MethodNotAllowedHttpException)
            if ($request->expectsJson())
                return response()->json(['erro' => 'Method_Not_Allowed'], $e->getStatusCode());

        if ($e instanceof TokenExpiredException)
            return response()->json(['token_expired'], 401);
            
        if ($e instanceof TokenInvalidException)
            return response()->json(['token_invalid'], 401);


        return parent::render($request, $e);
    }
}
