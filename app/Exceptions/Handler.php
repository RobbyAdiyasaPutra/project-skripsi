<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
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
     * A list of the exception types that should be reported.
     *
     * @var array<int, string>
     */
    protected $reportable = [
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Validation\ValidationException::class,
        // Tambahkan tipe pengecualian lainnya yang ingin dilaporkan di sini
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        // Melakukan logging kesalahan dan melakukan penanganan khusus
        $this->reportable(function (Throwable $e) {
            // Contoh menambahkan logging untuk pengecualian
            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                Log::warning('Model not found: ' . $e->getMessage());
            }

            // Anda juga bisa menambahkan tipe pengecualian lainnya yang lebih spesifik
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                Log::warning('Validation failed: ' . $e->getMessage());
            }
        });

        // Menangani pengecualian HTTP dan memberikan respons custom jika perlu
        $this->renderable(function (Throwable $e, Request $request) {
            // Jika ini adalah pengecualian not found
            if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                return response()->view('errors.404', [], 404);
            }

            // Jika ini adalah pengecualian unauthorized
            if ($e instanceof \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException) {
                return response()->view('errors.401', [], 401);
            }

            // Menangani pengecualian lain sesuai kebutuhan
            if ($e instanceof \Illuminate\Auth\Access\AuthorizationException) {
                return response()->view('errors.403', [], 403);
            }

            // Default handler untuk pengecualian lainnya
            return parent::render($request, $e);
        });
    }
}
