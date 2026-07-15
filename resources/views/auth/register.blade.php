@extends('layouts.app')

@section('content')
<div class="login-wrap">
    <div class="login-stage">
        <div class="login-box" style="max-width:640px;">
            <div class="login-brandmark">
                <img src="{{ asset('logo.png') }}" alt="Logo" style="width: 44px; height: 44px; object-fit: contain;">
                <div class="tx"><strong>Recap Support Tracker</strong><span>PT SAKTI KINERJA KOLABORASINDO</span></div>
            </div>

            <div class="login-panel-card" style="text-align:left;">
                {{-- Header --}}
                <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:22px;">
                    <div>
                        <h1 style="font-family:var(--font-display); font-size:22px; font-weight:600; margin:0 0 4px; color:var(--ink);">Daftar Akun Baru</h1>
                        <p style="margin:0; font-size:13px; color:var(--ink-soft); font-family:var(--font-mono);">Untuk perwakilan koperasi / instansi mitra (Pelapor)</p>
                    </div>
                    <a href="{{ route('login') }}" style="color:var(--ink-soft); font-size:20px; text-decoration:none; line-height:1;" title="Kembali ke Login">&times;</a>
                </div>

                {{-- Flash message sukses --}}
                @if(session('success'))
                    <div id="register-success" class="alert-dismiss" style="display: flex; justify-content: space-between; align-items: center; padding: 12px 14px; background: var(--sage-soft); color: var(--sage); border-radius: 8px; margin-bottom: 18px; font-size: 13px; font-weight: 600; border: 1px solid rgba(46, 125, 82, 0.2); transition: opacity 0.6s ease, transform 0.6s ease;">
                        <span>{{ session('success') }}</span>
                        <button type="button" onclick="document.getElementById('register-success').style.display='none'" style="background: none; border: none; color: var(--sage); cursor: pointer; font-size: 18px; font-weight: bold; line-height: 1; padding: 0 4px; margin-left: 10px;">&times;</button>
                    </div>
                @endif

                {{-- Flash message error global --}}
                @if(session('error'))
                    <div id="register-error" class="alert-dismiss" style="display: flex; justify-content: space-between; align-items: center; padding: 12px 14px; background: var(--amber-soft); color: var(--amber); border-radius: 8px; margin-bottom: 18px; font-size: 13px; font-weight: 600; border: 1px solid rgba(220, 53, 69, 0.2); transition: opacity 0.6s ease, transform 0.6s ease;">
                        <span>{{ session('error') }}</span>
                        <button type="button" onclick="document.getElementById('register-error').style.display='none'" style="background: none; border: none; color: var(--amber); cursor: pointer; font-size: 18px; font-weight: bold; line-height: 1; padding: 0 4px; margin-left: 10px;">&times;</button>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Baris 1: Nama Koperasi & Nama PIC --}}
                    <div class="register-grid">
                        <div class="field {{ $errors->has('nama_instansi') ? 'field-error' : '' }}">
                            <label for="nama_instansi">Nama Koperasi / Instansi</label>
                            <input type="text" id="nama_instansi" name="nama_instansi" value="{{ old('nama_instansi') }}" placeholder="cth. Koperasi Kredit Sejahtera" required>
                            @error('nama_instansi')
                                <span class="field-error-msg">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="field {{ $errors->has('nama') ? 'field-error' : '' }}">
                            <label for="nama">Nama PIC</label>
                            <input type="text" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Nama lengkap PIC" required>
                            @error('nama')
                                <span class="field-error-msg">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Baris 2: Email & No HP --}}
                    <div class="register-grid">
                        <div class="field {{ $errors->has('email') ? 'field-error' : '' }}">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@koperasi.id" required>
                            @error('email')
                                <span class="field-error-msg">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="field {{ $errors->has('no_hp') ? 'field-error' : '' }}">
                            <label for="no_hp">No. HP / WhatsApp</label>
                            <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xx-xxxx-xxxx" required>
                            @error('no_hp')
                                <span class="field-error-msg">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Baris 3: Kata Sandi & Konfirmasi --}}
                    <div class="register-grid">
                        <div class="field {{ $errors->has('password') ? 'field-error' : '' }}">
                            <label for="password">Kata Sandi</label>
                            <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" required>
                            @error('password')
                                <span class="field-error-msg">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="field {{ $errors->has('password_confirmation') ? 'field-error' : '' }}">
                            <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi kata sandi" required>
                            @error('password_confirmation')
                                <span class="field-error-msg">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Pesan verifikasi --}}
                    <p class="register-notice">
                        Akun baru akan diverifikasi oleh Tim Support sebelum dapat digunakan untuk membuat laporan.
                    </p>

                    {{-- Tombol aksi --}}
                    <div class="register-actions">
                        <a href="{{ route('login') }}" class="btn btn-ghost" style="flex:1; justify-content:center;">Sudah punya akun? Masuk</a>
                        <button type="submit" class="btn btn-primary" style="flex:1; justify-content:center;">Daftar Akun</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
