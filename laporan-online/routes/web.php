<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;

Route::get('/', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/create', [LaporanController::class, 'create'])->name('laporan.create');
Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');
Route::get('/laporan/{id}/edit', [LaporanController::class, 'edit'])->name('laporan.edit');
Route::put('/laporan/{id}', [LaporanController::class, 'update'])->name('laporan.update');
Route::delete('/laporan/{id}', [LaporanController::class, 'destroy'])->name('laporan.destroy');

