<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LaporanApiController;

Route::get('/health', fn() => response()->json(['status' => 'ok']));

// API CRUD laporan
Route::apiResource('laporans', LaporanApiController::class);
