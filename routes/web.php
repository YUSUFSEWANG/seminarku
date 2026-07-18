<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\User;
use Illuminate\Support\Facades\Route;

// ── Landing Page ──────────────────────────────────────────────
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    }
    return view('welcome');
})->name('home');

// ── Admin Routes ──────────────────────────────────────────────
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'active', 'admin'])
    ->group(function () {

        Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

        // Kegiatan (CRUD)
        Route::resource('kegiatan', Admin\KegiatanController::class);

        // User Management
        Route::resource('users', Admin\UserController::class);
        Route::patch('users/{user}/toggle-active', [Admin\UserController::class, 'toggleActive'])->name('users.toggle-active');

        // Pendaftaran
        Route::get('pendaftaran', [Admin\PendaftaranController::class, 'index'])->name('pendaftaran.index');
        Route::get('pendaftaran/{pendaftaran}', [Admin\PendaftaranController::class, 'show'])->name('pendaftaran.show');
        Route::patch('pendaftaran/{pendaftaran}/konfirmasi', [Admin\PendaftaranController::class, 'konfirmasi'])->name('pendaftaran.konfirmasi');
        Route::patch('pendaftaran/{pendaftaran}/tolak', [Admin\PendaftaranController::class, 'tolak'])->name('pendaftaran.tolak');
    });

// ── User Routes ───────────────────────────────────────────────
Route::prefix('user')
    ->name('user.')
    ->middleware(['auth', 'active'])
    ->group(function () {

        Route::get('/dashboard', [User\DashboardController::class, 'index'])->name('dashboard');

        // Kegiatan (hanya lihat)
        Route::get('kegiatan', [User\KegiatanController::class, 'index'])->name('kegiatan.index');
        Route::get('kegiatan/{kegiatan}', [User\KegiatanController::class, 'show'])->name('kegiatan.show');

        // Pendaftaran
        Route::get('pendaftaran', [User\PendaftaranController::class, 'index'])->name('pendaftaran.index');
        Route::post('pendaftaran', [User\PendaftaranController::class, 'store'])->name('pendaftaran.store');
        Route::get('pendaftaran/{pendaftaran}', [User\PendaftaranController::class, 'show'])->name('pendaftaran.show');
        Route::patch('pendaftaran/{pendaftaran}/batalkan', [User\PendaftaranController::class, 'batalkan'])->name('pendaftaran.batalkan');
    });

// ── Profile Routes ────────────────────────────────────────────
Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
