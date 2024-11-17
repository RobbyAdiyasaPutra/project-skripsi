<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CriteriaModelController;
use App\Http\Controllers\AlternatifModelController;
use App\Http\Controllers\DecisionMatrixController;
use App\Http\Controllers\VikorMethodController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/dashboard', function () {
    return view('dashboard.home');
});

Route::prefix('/')->group (function () {
    Route::get('/', function () {
        return view('dashboard.home');
    });
    Route::resource('criteria', CriteriaModelController::class);
    Route::resource('alternatif', AlternatifModelController::class);
    Route::resource('decisionmatrix', DecisionMatrixController::class);
    Route::get('/calculate', [VikorMethodController::class, 'index'])->name('calculate.index');
});
