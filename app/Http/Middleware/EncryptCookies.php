<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * Daftar nama cookie yang tidak perlu dienkripsi.
     *
     * @var array<int, string>
     */
    protected $except = [
        'session_id', // Misalnya cookie untuk ID sesi
        'remember_token', // Cookie untuk 'remember me' login
        // Tambahkan nama cookie lainnya yang tidak perlu dienkripsi
    ];
}
