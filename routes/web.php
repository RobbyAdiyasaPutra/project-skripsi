<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CriteriaModelController;
use App\Http\Controllers\AlternatifModelController;
use App\Http\Controllers\DecisionMatrixController;
use App\Http\Controllers\VikorMethodController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;

/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| Routes are loaded by the RouteServiceProvider and assigned to the "web" middleware group.
| Make something great!
|
*/

// Halaman Dashboard setelah login
Route::middleware('auth')->get('/dashboard', function () {
    return view('dashboard.home');
})->name('dashboard');

// Grup rute untuk home, login, dan logout
Route::prefix('/')->group(function () {
    // Halaman utama (Welcome) - tanpa autentikasi
    Route::get('/', function () {
        return view('welcome');
    });

    // Rute login dan proses login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Rute untuk logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Halaman home setelah login, hanya bisa diakses jika sudah login
    Route::middleware('auth')->get('/home', [HomeController::class, 'index'])->name('home');

    // Rute-rute resource yang ada
    Route::middleware('auth')->resource('criteria', CriteriaModelController::class);
    Route::middleware('auth')->resource('alternatif', AlternatifModelController::class);
    Route::middleware('auth')->resource('decisionmatrix', DecisionMatrixController::class);
    Route::middleware('auth')->get('/calculate', [VikorMethodController::class, 'index'])->name('calculate.index');
});

// Rute untuk registrasi dan autentikasi
Auth::routes();

// Menambahkan rute /home jika diperlukan
// Jika sudah menggunakan rute di atas, ini bisa dihapus untuk menghindari duplikasi
Route::get('/home', [HomeController::class, 'index'])->name('home');
