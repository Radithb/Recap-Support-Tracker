<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\UserVerificationController;
use App\Http\Middleware\IsPelapor;
use App\Http\Middleware\IsSupport;
use App\Http\Middleware\IsSuperAdmin;

Route::get('/', function () {
    return redirect('/login');
});

// ROUTE SEMENTARA UNTUK MIGRASI (InfinityFree)
Route::get('/run-migrations', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        return "Migrasi Database & Clear Cache Berhasil! Silakan kembali ke website.";
    } catch (\Exception $e) {
        return "Terjadi Kesalahan: " . $e->getMessage();
    }
});

// ROUTE SEMENTARA: Fix kolom cutoff yang belum ada
Route::get('/fix-cutoff-columns', function () {
    $results = [];
    $columns = [
        'periode_transaksi_terakhir' => "ALTER TABLE implementasi_koperasi ADD COLUMN periode_transaksi_terakhir VARCHAR(255) NULL",
        'saldo_terakhir' => "ALTER TABLE implementasi_koperasi ADD COLUMN saldo_terakhir VARCHAR(255) NULL",
        'tanggal_tutup_buku' => "ALTER TABLE implementasi_koperasi ADD COLUMN tanggal_tutup_buku DATE NULL",
        'tanggal_mulai_aplikasi' => "ALTER TABLE implementasi_koperasi ADD COLUMN tanggal_mulai_aplikasi DATE NULL",
        'pic_validasi' => "ALTER TABLE implementasi_koperasi ADD COLUMN pic_validasi VARCHAR(255) NULL",
        'catatan_cutoff' => "ALTER TABLE implementasi_koperasi ADD COLUMN catatan_cutoff TEXT NULL",
        'status_cutoff' => "ALTER TABLE implementasi_koperasi ADD COLUMN status_cutoff VARCHAR(255) NULL DEFAULT 'Menunggu Penentuan Cut-Off'",
        'tanggal_followup' => "ALTER TABLE implementasi_koperasi ADD COLUMN tanggal_followup DATE NULL",
        'hasil_komunikasi' => "ALTER TABLE implementasi_koperasi ADD COLUMN hasil_komunikasi TEXT NULL",
        'kendala_koperasi' => "ALTER TABLE implementasi_koperasi ADD COLUMN kendala_koperasi TEXT NULL",
        'komitmen_koperasi' => "ALTER TABLE implementasi_koperasi ADD COLUMN komitmen_koperasi TEXT NULL",
        'tanggal_followup_berikutnya' => "ALTER TABLE implementasi_koperasi ADD COLUMN tanggal_followup_berikutnya DATE NULL",
    ];
    foreach ($columns as $col => $sql) {
        if (!\Illuminate\Support\Facades\Schema::hasColumn('implementasi_koperasi', $col)) {
            \Illuminate\Support\Facades\DB::statement($sql);
            $results[] = "Kolom '{$col}' berhasil ditambahkan.";
        } else {
            $results[] = "Kolom '{$col}' sudah ada (skip).";
        }
    }
    return "<pre>" . implode("\n", $results) . "\n\nSelesai! Silakan kembali ke halaman implementasi.</pre>";
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'storeRegister']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Lupa Kata Sandi & Reset Password (via Email SMTP)
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::middleware('auth')->group(function () {
    Route::get('/profil-instansi', function () {
        $aplikasis = \App\Models\MasterAplikasi::where('is_active', true)->get();
        return view('profil-instansi', compact('aplikasis'));
    })->name('profil.instansi');
    
    Route::put('/profil-instansi', [AuthController::class, 'updateInstansi'])->name('profil.instansi.update');
    Route::put('/profil/password', [AuthController::class, 'updatePassword'])->name('profil.password.update');

    Route::get('/pengaturan', [AuthController::class, 'pengaturan'])->name('pengaturan');
    Route::put('/pengaturan', [AuthController::class, 'updatePengaturan'])->name('pengaturan.update');
    Route::post('/pengaturan/bahasa', [AuthController::class, 'updateLanguage'])->name('pengaturan.bahasa');

    // Implementasi & Go-Live Koperasi
    Route::middleware([\App\Http\Middleware\IsSupport::class])->prefix('implementasi')->name('implementasi.')->group(function () {
        Route::get('/', [\App\Http\Controllers\ImplementasiController::class, 'index'])->name('index');
        Route::post('/', [\App\Http\Controllers\ImplementasiController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [\App\Http\Controllers\ImplementasiController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\ImplementasiController::class, 'update'])->name('update');
        Route::put('/{id}/golive', [\App\Http\Controllers\ImplementasiController::class, 'updateGoLive'])->name('golive.update');
        Route::put('/{id}/cutoff', [\App\Http\Controllers\ImplementasiController::class, 'updateCutOff'])->name('cutoff.update');
        Route::put('/{id}/followup', [\App\Http\Controllers\ImplementasiController::class, 'updateFollowUp'])->name('followup.update');
        Route::get('/{id}', [\App\Http\Controllers\ImplementasiController::class, 'show'])->name('show');
        Route::delete('/{id}', [\App\Http\Controllers\ImplementasiController::class, 'destroy'])->name('destroy');
        Route::put('/checklist/{id}', [\App\Http\Controllers\ImplementasiController::class, 'updateChecklist'])->name('checklist.update');
        Route::post('/{id}/checklist', [\App\Http\Controllers\ImplementasiController::class, 'storeChecklist'])->name('checklist.store');
        Route::delete('/checklist/{id}', [\App\Http\Controllers\ImplementasiController::class, 'destroyChecklist'])->name('checklist.destroy');
    });
});

// Akses Pelapor
Route::middleware(['auth', IsPelapor::class])->prefix('pelapor')->name('pelapor.')->group(function () {
    Route::get('/dashboard', [TicketController::class, 'pelaporDashboard'])->name('dashboard');
    Route::get('/riwayat', [TicketController::class, 'pelaporRiwayat'])->name('riwayat');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
    Route::view('/bantuan', 'pelapor.bantuan')->name('bantuan');
    Route::get('/faq/search', [FaqController::class, 'searchPublic'])->name('faq.search');

});

// Akses Support
Route::middleware(['auth', IsSupport::class])->prefix('support')->name('support.')->group(function () {
    Route::get('/dashboard', [TicketController::class, 'supportDashboard'])->name('dashboard');
    Route::put('/tickets/{ticket}', [TicketController::class, 'updateSupport'])->name('tickets.update');
    
    // Reporting
    Route::get('/recap', [ReportController::class, 'index'])->name('recap');
    Route::get('/recap/diagram', [ReportController::class, 'diagram'])->name('recap.diagram');
    Route::get('/recap/table', [ReportController::class, 'table'])->name('recap.table');
    Route::get('/recap/history-pic', [ReportController::class, 'historyPic'])->name('recap.history-pic');
    Route::get('/recap/template-surat', [ReportController::class, 'templateSurat'])->name('recap.template-surat');
    Route::get('/recap/detail', [ReportController::class, 'detail'])->name('recap.detail');
    
    // Master Data
    Route::get('/master-data', [MasterDataController::class, 'index'])->name('master-data.index');
    Route::get('/master-data/export', [MasterDataController::class, 'export'])->name('master-data.export');
    Route::post('/master-data/aplikasi', [MasterDataController::class, 'storeAplikasi'])->name('master-data.aplikasi.store');
    Route::put('/master-data/aplikasi/{id}', [MasterDataController::class, 'updateAplikasi'])->name('master-data.aplikasi.update');
    Route::delete('/master-data/aplikasi/{id}', [MasterDataController::class, 'destroyAplikasi'])->name('master-data.aplikasi.destroy');
    Route::post('/master-data/kategori', [MasterDataController::class, 'storeKategori'])->name('master-data.kategori.store');
    Route::put('/master-data/kategori/{id}', [MasterDataController::class, 'updateKategori'])->name('master-data.kategori.update');
    Route::delete('/master-data/kategori/{id}', [MasterDataController::class, 'destroyKategori'])->name('master-data.kategori.destroy');

    // Verifikasi Akun Pelapor
    Route::put('/users/{user}/verify', [UserVerificationController::class, 'verify'])->name('users.verify');
    Route::delete('/users/{user}/reject', [UserVerificationController::class, 'reject'])->name('users.reject');
    
    // Profil Saya (Support)
    Route::get('/profil-saya', [AuthController::class, 'showProfilSaya'])->name('profil.saya');
    Route::put('/profil-saya', [AuthController::class, 'updateProfilSaya'])->name('profil.saya.update');

    // Profil Lengkap Pelapor
    Route::get('/pelapor/{user}/profil', [AuthController::class, 'showPelaporProfile'])->name('pelapor.profile');

    // FAQ CRUD (Master Data)
    Route::post('/master-data/faq', [FaqController::class, 'store'])->name('master-data.faq.store');
    Route::put('/master-data/faq/{id}', [FaqController::class, 'update'])->name('master-data.faq.update');
    Route::delete('/master-data/faq/{id}', [FaqController::class, 'destroy'])->name('master-data.faq.destroy');

    // FAQ API (JSON untuk modal insert di Support)
    Route::get('/faq/list', [FaqController::class, 'allForSupport'])->name('faq.list');
});

use App\Http\Controllers\SuperAdminController;

// Akses Super Admin (Eksklusif)
Route::middleware(['auth', IsSuperAdmin::class])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/pengguna', [SuperAdminController::class, 'pengguna'])->name('pengguna');
    Route::post('/pengguna', [SuperAdminController::class, 'storePengguna'])->name('pengguna.store');
    Route::put('/pengguna/{user}', [SuperAdminController::class, 'updatePengguna'])->name('pengguna.update');
    Route::delete('/pengguna/{user}', [SuperAdminController::class, 'destroyPengguna'])->name('pengguna.destroy');
});
