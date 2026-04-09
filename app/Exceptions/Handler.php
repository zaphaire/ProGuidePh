<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Error;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Error $e) {
            if (str_contains($e->getMessage(), 'Class "PDO" not found')) {
                return response()->view('errors.pdo', [], 500);
            }
        });
    }

    public function report(Throwable $e)
    {
        parent::report($e);
    }

    public function render($request, Throwable $e)
    {
        if (str_contains($e->getMessage(), 'Class "PDO" not found')) {
            return response()->view('errors.pdo', [], 500);
        }

        if (app()->environment('local')) {
            return parent::render($request, $e);
        }

        $status = 500;
        if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface && method_exists($e, 'getStatusCode')) {
            $status = $e->getStatusCode();
        }

        return response()->view('errors.general', [
            'message' => $e->getMessage(),
            'status' => $status
        ], $status);
    }
}