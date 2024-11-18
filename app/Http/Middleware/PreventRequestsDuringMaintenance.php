<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

class PreventRequestsDuringMaintenance extends Middleware
{
    /**
     * Daftar URI yang masih bisa diakses meskipun mode pemeliharaan diaktifkan.
     *
     * @var array<int, string>
     */
    protected $except = [
        'status',          // Misalnya status untuk menunjukkan bahwa aplikasi sedang dalam pemeliharaan
        'health-check',    // Misalnya endpoint untuk health check
        'login',           // Misalnya login untuk mengizinkan akses admin
        // Tambahkan URI lain yang perlu dikecualikan dari pemeliharaan
    ];
}
