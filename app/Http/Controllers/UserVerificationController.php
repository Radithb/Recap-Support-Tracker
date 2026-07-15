<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Instansi;
use App\Enums\UserRole;
use Illuminate\Support\Facades\DB;

class UserVerificationController extends Controller
{
    /**
     * Verifikasi (setujui) akun pelapor.
     */
    public function verify(User $user)
    {
        // Hanya user pelapor yang belum diverifikasi yang bisa diverifikasi
        if ($user->role !== UserRole::PELAPOR || $user->is_verified) {
            return back()->with('error', 'Akun tidak valid untuk diverifikasi.');
        }

        $user->update(['is_verified' => true]);

        return back()->with('success', "Akun \"{$user->nama}\" berhasil diverifikasi.");
    }

    /**
     * Tolak (hapus) akun pelapor beserta instansi terkait.
     */
    public function reject(User $user)
    {
        // Hanya user pelapor yang belum diverifikasi yang bisa ditolak
        if ($user->role !== UserRole::PELAPOR || $user->is_verified) {
            return back()->with('error', 'Akun tidak valid untuk ditolak.');
        }

        $userName = $user->nama;

        DB::transaction(function () use ($user) {
            $instansi = $user->instansi;
            $user->delete();

            // Hapus instansi jika tidak ada user lain yang terhubung
            if ($instansi && $instansi->users()->count() === 0) {
                $instansi->delete();
            }
        });

        return back()->with('success', "Akun \"{$userName}\" berhasil ditolak dan dihapus.");
    }
}
