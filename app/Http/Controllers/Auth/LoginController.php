<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout'); // Membatasi middleware logout hanya untuk user yang sudah login
    }

    /**
     * Menampilkan form login (tampilan kustom)
     */
    public function showLoginForm()
    {
        return view('auth.login'); // Sesuaikan dengan file login.blade.php yang sudah kamu buat
    }

    public function logout()
    {
        $this->guard()->logout();
        return redirect('/'); // Setelah logout, redirect ke halaman depan atau welcome
    }
}
