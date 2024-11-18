<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |----------------------------------------------------------------------
    | Password Reset Controller
    |----------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * 
     *
     * @var string
     */
    protected $redirectTo = '/home'; // Kamu bisa mengganti ini dengan URL lain sesuai kebutuhan.

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Pastikan hanya pengguna yang sudah terautentikasi yang bisa mengakses halaman reset password
        $this->middleware('auth');
    }
}
