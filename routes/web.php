<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserVerificationController;
use App\Http\Middleware\IsPelapor;
use App\Http\Middleware\IsSupport;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'storeRegister']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/profil-instansi', function () {
        return view('profil-instansi');
    })->name('profil.instansi');
    
    Route::put('/profil-instansi', [AuthController::class, 'updateInstansi'])->name('profil.instansi.update');
});

// Akses Pelapor
Route::middleware(['auth', IsPelapor::class])->prefix('pelapor')->name('pelapor.')->group(function () {
    Route::get('/dashboard', [TicketController::class, 'pelaporDashboard'])->name('dashboard');
    Route::get('/riwayat', [TicketController::class, 'pelaporRiwayat'])->name('riwayat');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
});

// Akses Support
Route::middleware(['auth', IsSupport::class])->prefix('support')->name('support.')->group(function () {
    Route::get('/dashboard', [TicketController::class, 'supportDashboard'])->name('dashboard');
    Route::put('/tickets/{ticket}', [TicketController::class, 'updateSupport'])->name('tickets.update');
    
    // Reporting
    Route::get('/recap', [ReportController::class, 'index'])->name('recap');
    
    // Master Data
    Route::get('/master-data', [MasterDataController::class, 'index'])->name('master-data.index');
    Route::post('/master-data/aplikasi', [MasterDataController::class, 'storeAplikasi'])->name('master-data.aplikasi.store');
    Route::post('/master-data/kategori', [MasterDataController::class, 'storeKategori'])->name('master-data.kategori.store');

    // Verifikasi Akun Pelapor
    Route::put('/users/{user}/verify', [UserVerificationController::class, 'verify'])->name('users.verify');
    Route::delete('/users/{user}/reject', [UserVerificationController::class, 'reject'])->name('users.reject');
    
    // Profil Saya (Support)
    Route::get('/profil-saya', [AuthController::class, 'showProfilSaya'])->name('profil.saya');
    Route::put('/profil-saya', [AuthController::class, 'updateProfilSaya'])->name('profil.saya.update');
});
