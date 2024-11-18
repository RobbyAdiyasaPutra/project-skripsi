<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
    /*
    |----------------------------------------------------------------------
    | Email Verification Controller
    |----------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/home'; // Ganti dengan rute tujuan setelah verifikasi

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Middleware untuk memastikan hanya pengguna yang sudah login yang dapat mengakses halaman verifikasi email
        $this->middleware('auth');
        
        // Middleware untuk memastikan URL verifikasi adalah signed URL yang valid
        $this->middleware('signed')->only('verify');
        
        // Middleware untuk membatasi jumlah permintaan verifikasi dan pengiriman ulang email
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Show the email verification notice.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('auth.verify'); // Tampilan untuk verifikasi email, sesuaikan dengan tampilan yang kamu inginkan
    }
}

