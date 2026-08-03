<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstitusiController;
use App\Http\Controllers\PrestasiBelmawaController;
use App\Http\Controllers\PrestasiMandiriController;
use App\Http\Controllers\RekognisiController;
use App\Http\Controllers\SertifikasiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'login')->name('login')->middleware('guest');
    Route::post('/login', 'authenticate')->name('login.post')->middleware('guest');
    Route::post('/logout', 'logout')->name('logout')->middleware('auth');
});

Route::middleware(['auth', 'checkrole'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Profile Routes
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile.show');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    // Change Password Routes
    Route::get('/change-password', [AuthController::class, 'editPassword'])->name('password.edit');
    Route::put('/change-password', [AuthController::class, 'updatePassword'])->name('password.update');

    // User Management Resource Routes
    Route::resource('users', UserController::class);

    // Prestasi Belmawa Resource Routes
    Route::resource('prestasi-belmawa', PrestasiBelmawaController::class);

    // Prestasi Mandiri Resource Routes
    Route::resource('prestasi-mandiri', PrestasiMandiriController::class);

    // Rekognisi Resource Routes
    Route::resource('rekognisi', RekognisiController::class);

    // Sertifikasi Resource Routes
    Route::resource('sertifikasi', SertifikasiController::class);

    // Institusi Resource Routes
    Route::resource('institusi', InstitusiController::class);
});