<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/*
|-------------------------------------------------------------------------- 
| API Routes 
|-------------------------------------------------------------------------- 
| 
| Here is where you can register API routes for your application. 
| These routes are loaded by the RouteServiceProvider and all of them will 
| be assigned to the "api" middleware group. 
| 
*/

// Rute untuk mendapatkan informasi pengguna
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rute untuk logout API
Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $request->user()->tokens->each(function ($token) {
        $token->delete(); // Menghapus semua token yang dimiliki oleh pengguna
    });

    return response()->json(['message' => 'Logged out successfully.'], 200);
});

