<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\ItemNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{

    use ApiResponse;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable  $e)
    {
        if (!request()->wantsJson()){
            return parent::render($request, $e);
        }
        
        if ($e instanceof AuthenticationException) {
            return $this::unsuccessResponse($e->getMessage(), 401);
        }

        if ($e instanceof NotFoundHttpException) {
            return $this::unsuccessResponse($e->getMessage(), $e->getStatusCode());
        }

        if ($e instanceof ModelNotFoundException) {
            return $this::unsuccessResponse($e->getMessage(), 404);
        }

        if ($e instanceof ItemNotFoundException) {
            return $this::unsuccessResponse($e->getMessage(), 404);
        }

        if ($e instanceof QueryException) {
            return $this::unsuccessResponse($e->errorInfo, 500);
        }

        if ($e instanceof ValidationException) {
            return $this::unsuccessResponse($e->errors(), 400);
        }
        
        if ($e instanceof AuthorizationException) {
            return $this::unsuccessResponse($e->getMessage(), 403);
        }

        return $this::unsuccessResponse($e->getMessage(), 500); 
    }
}
