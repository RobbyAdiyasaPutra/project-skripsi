<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$guards
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // Tentukan default guard jika tidak ada yang diberikan
        $guards = empty($guards) ? [null] : $guards;

        // Periksa setiap guard untuk memastikan apakah pengguna terautentikasi
        foreach ($guards as $guard) {
            // Jika pengguna terautentikasi, alihkan ke halaman beranda (HOME)
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
        }

        // Jika pengguna belum terautentikasi, lanjutkan permintaan
        return $next($request);
    }
}
