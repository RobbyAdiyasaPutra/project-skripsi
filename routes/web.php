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
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Halaman Dashboard setelah login
Route::get('/dashboard', function () {
    return view('dashboard.home');
})->middleware('auth'); // Hanya bisa diakses oleh pengguna yang sudah login

// Grup rute untuk home, login, dan logout
Route::prefix('/')->group(function () {
    // Halaman utama (Welcome)
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
    Route::resource('criteria', CriteriaModelController::class);
    Route::resource('alternatif', AlternatifModelController::class);
    Route::resource('decisionmatrix', DecisionMatrixController::class);
    Route::get('/calculate', [VikorMethodController::class, 'index'])->name('calculate.index');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
