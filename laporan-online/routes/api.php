<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LaporanApiController;

Route::get('/health', fn() => response()->json(['status' => 'ok']));

// CRUD API laporan online
Route::apiResource('laporan-online', LaporanApiController::class);
