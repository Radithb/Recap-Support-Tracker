<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Instansi;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    public function pengguna()
    {
        // Pastikan hanya Super Admin yang bisa mengakses
        if (Auth::user()->role !== UserRole::SUPERADMIN) {
            return redirect('/login')->with('error', 'Akses ditolak.');
        }

        $users = User::with('instansi')->orderBy('created_at', 'desc')->get();
        $instansis = Instansi::all();
        
        return view('superadmin.pengguna', compact('users', 'instansis'));
    }

    public function storePengguna(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => ['required', new Enum(UserRole::class)],
            'instansi_id' => 'nullable|exists:instansis,instansi_id',
        ]);

        $data = $request->only(['nama', 'email', 'role', 'instansi_id']);
        $data['password'] = Hash::make($request->password);
        $data['is_verified'] = true; // Selalu aktif karena ditambahkan oleh Super Admin

        // Validasi khusus: Pelapor harus punya instansi, selain pelapor instansinya null
        if ($data['role'] === UserRole::PELAPOR->value && empty($data['instansi_id'])) {
            return back()->with('error', 'Instansi wajib diisi untuk role Pelapor.');
        }
        
        if ($data['role'] !== UserRole::PELAPOR->value) {
            $data['instansi_id'] = null;
        }

        User::create($data);

        return back()->with('success', 'Pengguna berhasil ditambahkan!');
    }

    public function updatePengguna(Request $request, User $user)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->user_id . ',user_id',
            'role' => ['required', new Enum(UserRole::class)],
            'instansi_id' => 'nullable|exists:instansis,instansi_id',
            'password' => 'nullable|string|min:8',
        ]);

        $data = $request->only(['nama', 'email', 'role', 'instansi_id']);
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($data['role'] === UserRole::PELAPOR->value && empty($data['instansi_id'])) {
            return back()->with('error', 'Instansi wajib diisi untuk role Pelapor.');
        }
        
        if ($data['role'] !== UserRole::PELAPOR->value) {
            $data['instansi_id'] = null;
        }

        $user->update($data);

        return back()->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function destroyPengguna(User $user)
    {
        // Mencegah super admin menghapus dirinya sendiri
        if ($user->user_id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $user->delete();
        return back()->with('success', 'Pengguna berhasil dihapus!');
    }
}
