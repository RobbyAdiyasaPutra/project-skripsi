<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ConfirmsPasswords;
use Illuminate\Http\Request;

class ConfirmPasswordController extends Controller
{
    /*
    |----------------------------------------------------------------------
    | Confirm Password Controller
    |----------------------------------------------------------------------
    |
    | This controller is responsible for handling password confirmations and
    | uses a simple trait to include the behavior. You're free to explore
    | this trait and override any functions that require customization.
    |
    */

    use ConfirmsPasswords;

    /**
     * Where to redirect users when the intended url fails.
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
        // Middleware untuk memastikan hanya pengguna yang sudah login yang dapat mengakses halaman konfirmasi password
        $this->middleware('auth');
    }

    /**
     * Show the password confirmation form.
     *
     * @return \Illuminate\View\View
     */
    public function showConfirmForm()
    {
        // Menampilkan form konfirmasi password
        return view('auth.passwords.confirm');
    }

    /**
     * Handle a password confirmation request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirm(Request $request)
    {
        // Validasi input password yang dimasukkan oleh user
        $request->validate([
            'password' => 'required|string|min:8|confirmed', // Aturan validasi password
        ]);

        // Mengkonfirmasi password
        if (\Hash::check($request->password, auth()->user()->password)) {
            // Jika password cocok, arahkan ke halaman yang diminta atau ke halaman home
            return redirect()->intended($this->redirectTo);
        }

        // Jika password tidak cocok, kembali dengan error
        return back()->withErrors(['password' => 'The provided password is incorrect.']);
    }
}
