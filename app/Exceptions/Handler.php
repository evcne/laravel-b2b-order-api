<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Helpers\Helper;


class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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

    public function render($request, Throwable $e)
    {
        if ($e instanceof ValidationException) {
            return response()->json([
                'message' => 'Geçersiz veri gönderildi. Lütfen veriyi kontrol ediniz.',
                'errors' => $e->errors(),
                'code' => 422
            ], 422);
        }

        if ($e instanceof AuthorizationException) {
            return response()->json([
                'message' => 'Bu işlemi gerçekleştirmek için yetkiniz yok.',
                'code' => 403
            ], 403);
        }

        if ($e instanceof NotFoundHttpException) {
            return response()->json([
                'message' => 'İstenen kaynak bulunamadı.',
                'code' => 404
            ], 404);
        }

        if ($e instanceof HttpException) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => $e->getStatusCode()
            ], $e->getStatusCode());
        }

        return response()->json([
            'message' => 'Sunucu hatası.Lütfen daha sonra tekrar deneyiniz.',
            'error' => $e->getMessage(),
            'code' => 404
        ], 500);
    }
}
