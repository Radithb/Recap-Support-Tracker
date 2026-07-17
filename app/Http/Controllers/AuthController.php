<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Instansi;
use App\Enums\UserRole;
use App\Http\Requests\StoreRegisterRequest;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            // Cek apakah akun Pelapor sudah diverifikasi oleh Tim Support
            if (Auth::user()->role === UserRole::PELAPOR && !Auth::user()->is_verified) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Akun Anda belum diverifikasi oleh Tim Support. Silakan tunggu proses verifikasi.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            if (Auth::user()->role === UserRole::SUPPORT) {
                return redirect()->intended('/support/dashboard');
            }
            return redirect()->intended('/pelapor/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Menampilkan form registrasi Pelapor.
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Memproses form registrasi Pelapor.
     * Business Logic:
     * 1. Buat record Instansi (nama_instansi + no_hp)
     * 2. Buat record User (nama PIC, email, password hash, instansi_id, role=Pelapor, is_verified=false)
     * 3. User baru harus diverifikasi oleh Tim Support sebelum bisa login.
     */
    public function storeRegister(StoreRegisterRequest $request)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
            // Langkah 1: Buat Instansi baru
            $instansi = Instansi::create([
                'nama_instansi' => $validated['nama_instansi'],
                'no_telp'       => $validated['no_hp'],
            ]);

            // Langkah 2: Buat User (Pelapor) terhubung dengan Instansi
            User::create([
                'nama'        => $validated['nama'],
                'email'       => $validated['email'],
                'password'    => Hash::make($validated['password']),
                'role'        => UserRole::PELAPOR->value,
                'instansi_id' => $instansi->instansi_id,
                'is_verified' => false, // Langkah 3: Harus diverifikasi Tim Support
            ]);
        });

        return redirect('/login')->with('success', 'Pendaftaran berhasil! Akun Anda akan diverifikasi oleh Tim Support sebelum dapat digunakan.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
    public function updateInstansi(Request $request)
    {
        $request->validate([
            'alamat' => ['nullable', 'string', 'max:255'],
            'no_telp' => ['nullable', 'string', 'max:50'],
            'aplikasis' => ['nullable', 'array'],
            'aplikasis.*' => ['exists:master_aplikasis,aplikasi_id'],
        ]);

        $user = Auth::user();
        if ($user && $user->instansi) {
            $user->instansi->update([
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
            ]);

            if ($request->has('aplikasis')) {
                $user->instansi->aplikasis()->sync($request->aplikasis);
            } else {
                $user->instansi->aplikasis()->sync([]);
            }
        }

        return back()->with('success', 'Profil Koperasi berhasil diperbarui!');
    }

    public function showProfilSaya()
    {
        return view('support.profil-saya');
    }

    public function updateProfilSaya(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->user_id . ',user_id'],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required_with' => 'Kata sandi saat ini harus diisi jika Anda ingin mengubah kata sandi.',
            'current_password.current_password' => 'Kata sandi saat ini yang Anda masukkan salah.',
        ]);

        $user->nama = $validated['nama'];
        $user->email = $validated['email'];
        
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Profil Anda berhasil diperbarui!');
    }

    public function pengaturan()
    {
        return view('pengaturan');
    }

    public function updatePengaturan(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->user_id . ',user_id'],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required_with' => 'Kata sandi saat ini harus diisi jika Anda ingin mengubah kata sandi.',
            'current_password.current_password' => 'Kata sandi saat ini yang Anda masukkan salah.',
        ]);

        $user->nama = $validated['nama'];
        $user->email = $validated['email'];
        
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Pengaturan akun berhasil disimpan!');
    }

    public function updateLanguage(Request $request)
    {
        $validated = $request->validate([
            'locale' => ['required', 'string', 'in:id,en'],
        ]);

        $user = Auth::user();
        $user->locale = $validated['locale'];
        $user->save();

        return back()->with('success', 'Preferensi bahasa berhasil diperbarui!');
    }
}
