<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/*',  // Contoh, mengecualikan semua rute API
        'webhook/*',  // Misalnya jika Anda menerima webhook
        // Tambahkan URI lain yang ingin dikecualikan dari verifikasi CSRF
    ];
}
