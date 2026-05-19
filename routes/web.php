<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\UserManageController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin routes
    Route::middleware('can:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::resource('lapangan', LapanganController::class);
        Route::resource('users', UserManageController::class);

        // Transaksi Admin
        Route::get('/transaksi', [TransaksiController::class, 'adminIndex'])->name('transaksi.index');
        Route::patch('/transaksi/{transaksi}/status', [TransaksiController::class, 'updateStatus'])->name('transaksi.updateStatus');

        // Laporan
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.exportPdf');
    });

    // User routes
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
        Route::get('/booking/{lapangan}', [TransaksiController::class, 'create'])->name('booking.create');
        Route::post('/booking', [TransaksiController::class, 'store'])->name('booking.store');
        Route::get('/booking/nota/{transaksi}', [TransaksiController::class, 'cetakNota'])->name('booking.nota');
    });
});