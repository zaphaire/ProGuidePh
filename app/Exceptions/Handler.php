<?php

namespace App\Exceptions;

use App\Mail\SystemErrorMail;
use App\Models\User;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
            $this->sendErrorNotification($e);
        });
    }

    public function report(Throwable $e)
    {
        $this->sendErrorNotification($e);
        parent::report($e);
    }

    private function sendErrorNotification(Throwable $e)
    {
        try {
            $severity = $this->getSeverity($e);
            $location = $e->getFile() . ':' . $e->getLine();
            $message = $e->getMessage();
            $userEmail = request()->user()->email ?? null;

            if (app()->environment('production')) {
                $adminEmails = User::where('is_admin', true)->pluck('email')->toArray();
                
                if (!empty($adminEmails)) {
                    Mail::to($adminEmails)->send(new SystemErrorMail(
                        $message,
                        $location,
                        $severity,
                        $userEmail
                    ));
                }
            }
        } catch (\Exception $ex) {
            Log::error('Failed to send error notification: ' . $ex->getMessage());
        }
    }

    private function getSeverity(Throwable $e): string
    {
        $message = strtolower($e->getMessage());
        
        if ($e instanceof \Illuminate\Database\QueryException) {
            return 'Database';
        }
        if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface) {
            return 'HTTP ' . $e->getStatusCode();
        }
        if (str_contains($message, 'memory') || str_contains($message, 'allowed memory size')) {
            return 'Critical - Memory';
        }
        if (str_contains($message, 'connection') || str_contains($message, 'connection refused')) {
            return 'Critical - Connection';
        }
        if (str_contains($message, 'permission') || str_contains($message, 'access denied')) {
            return 'Warning - Permission';
        }
        
        return 'Application';
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