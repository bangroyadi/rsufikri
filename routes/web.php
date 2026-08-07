<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

// Layanan & Informasi Subpage Routes
Route::get('/layanan/{slug}', [HomeController::class, 'layananPage'])->name('layanan.show');
Route::get('/informasi/{slug}', [HomeController::class, 'informasiPage'])->name('informasi.show');

// Dedicated Page Routes
Route::get('/profil', [HomeController::class, 'profilPage'])->name('profil');
Route::get('/jadwal-dokter', [HomeController::class, 'jadwalDokterPage'])->name('jadwal.dokter');
Route::get('/kontak', [HomeController::class, 'kontakPage'])->name('kontak');
Route::get('/karir', [HomeController::class, 'karirPage'])->name('karir');
Route::get('/buat-janji', [HomeController::class, 'buatJanjiPage'])->name('buat.janji');



// Admin Auth Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin Protected Routes
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
});
