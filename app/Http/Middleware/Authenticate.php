<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Menentukan jalur yang harus diarahkan jika pengguna belum terautentikasi.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo(Request $request): ?string
    {
        // Jika permintaan mengharapkan JSON, kembalikan null (artinya tidak ada redirect)
        // Jika tidak, arahkan ke rute login
        if (! $request->expectsJson()) {
            return route('login');
        }

        return null; // Tidak ada redirect untuk permintaan JSON
    }
}
