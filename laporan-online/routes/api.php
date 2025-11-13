<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanOnlineController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('api')->group(function () {

    // Semua route CRUD
    Route::apiResource('laporan-online', LaporanOnlineController::class);

    // Route tambahan agar POST + _method=PATCH bisa update data
    Route::post('/laporan-online/{id}', [LaporanOnlineController::class, 'update'])
        ->name('laporan-online.update');
});

// Public route
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected route (butuh token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
