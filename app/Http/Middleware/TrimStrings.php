<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

class TrimStrings extends Middleware
{
    /**
     * The names of the attributes that should not be trimmed.
     *
     * @var array<int, string>
     */
    protected $except = [
        'current_password',      // Password saat ini (biasanya untuk pengubahan password)
        'password',              // Password baru
        'password_confirmation', // Konfirmasi password baru
    ];
}
