<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\ReportController;
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

// Akses Pelapor
Route::middleware(['auth', IsPelapor::class])->prefix('pelapor')->name('pelapor.')->group(function () {
    Route::get('/dashboard', [TicketController::class, 'pelaporDashboard'])->name('dashboard');
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
});
