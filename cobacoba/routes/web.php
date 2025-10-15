<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IbuController;
use App\Http\Controllers\AnakController;
use App\Http\Controllers\TumbuhController;
use App\Http\Controllers\ImunisasiController;
use App\Http\Controllers\VerifikasiController;

// Redirect root ke login
Route::get('/', fn() => redirect()->route('login'));

// Auth routes (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected routes (authenticated users)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Ibu routes
    Route::prefix('ibu')->name('ibu.')->group(function () {
        Route::get('/', [IbuController::class, 'index'])->name('index');
        Route::get('/create', [IbuController::class, 'create'])->name('create');
        Route::post('/', [IbuController::class, 'store'])->name('store');
        Route::get('/{ibu}', [IbuController::class, 'show'])->name('show');
    });

    // Anak routes
    Route::prefix('anak')->name('anak.')->group(function () {
        Route::get('/', [AnakController::class, 'index'])->name('index');
        Route::get('/create', [AnakController::class, 'create'])->name('create');
        Route::post('/', [AnakController::class, 'store'])->name('store');
        Route::get('/{anak}', [AnakController::class, 'show'])->name('show');
    });

    // Tumbuh routes
    Route::prefix('tumbuh')->name('tumbuh.')->group(function () {
        Route::get('/', [TumbuhController::class, 'index'])->name('index');
        Route::get('/create/{anak}', [TumbuhController::class, 'create'])->name('create');
        Route::post('/store/{anak}', [TumbuhController::class, 'store'])->name('store');
    });

    // Imunisasi routes
    Route::prefix('imunisasi')->name('imunisasi.')->group(function () {
        Route::get('/', [ImunisasiController::class, 'index'])->name('index');
        Route::get('/create/{anak}', [ImunisasiController::class, 'create'])->name('create');
        Route::post('/store/{anak}', [ImunisasiController::class, 'store'])->name('store');
    });

    // Verifikasi routes (only for bidan, dokter, admin)
    Route::middleware(['role:bidan,dokter,admin'])->group(function () {
        Route::prefix('verifikasi')->name('verifikasi.')->group(function () {
            Route::get('/', [VerifikasiController::class, 'index'])->name('index');
            Route::post('/{id}/approve', [VerifikasiController::class, 'approve'])->name('approve');
            Route::post('/{id}/reject', [VerifikasiController::class, 'reject'])->name('reject');
        });
    });
});
