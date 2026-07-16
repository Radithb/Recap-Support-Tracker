@extends('layouts.app')

@section('page_title', 'Pengaturan')
@section('page_subtitle', 'Kelola Keamanan dan Preferensi Akun')

@section('content')
<div class="fade-up" style="animation-delay: 0.1s;">
    
    @if(session('success'))
        <div id="success-alert" class="alert-dismiss fade-up" style="animation-delay: 0.2s; display: flex; justify-content: space-between; align-items: center; padding: 12px 14px; background: var(--sage-soft); color: var(--sage); border-radius: 8px; margin-bottom: 24px; font-size: 13.5px; font-weight: 600; border: 1px solid rgba(46, 125, 82, 0.2); transition: opacity 0.6s ease, transform 0.6s ease;">
            <span>{{ session('success') }}</span>
            <button type="button" onclick="document.getElementById('success-alert').style.display='none'" style="background: none; border: none; color: var(--sage); cursor: pointer; font-size: 18px; font-weight: bold; line-height: 1; padding: 0 4px; margin-left: 10px;">&times;</button>
        </div>
    @endif
    
    @if($errors->any())
        <div id="error-alert" class="alert-dismiss fade-up" style="animation-delay: 0.2s; display: flex; justify-content: space-between; align-items: center; padding: 12px 14px; background: #fee2e2; color: #dc2626; border-radius: 8px; margin-bottom: 24px; font-size: 13.5px; font-weight: 600; border: 1px solid rgba(220, 38, 38, 0.2);">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" onclick="document.getElementById('error-alert').style.display='none'" style="background: none; border: none; color: #dc2626; cursor: pointer; font-size: 18px; font-weight: bold; line-height: 1; padding: 0 4px; margin-left: 10px; align-self: flex-start;">&times;</button>
        </div>
    @endif

    <style>
        .toggle-switch {
            appearance: none;
            width: 40px;
            height: 20px;
            background: #cbd5e1;
            border-radius: 20px;
            position: relative;
            cursor: pointer;
            outline: none;
            transition: background 0.3s ease;
        }
        .toggle-switch:checked {
            background: var(--sage);
        }
        .toggle-switch::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: 16px;
            height: 16px;
            background: white;
            border-radius: 50%;
            transition: transform 0.3s ease;
        }
        .toggle-switch:checked::after {
            transform: translateX(20px);
        }
    </style>

    <div class="panel" style="padding: 30px; max-width: 100%;">
        <div style="margin-bottom: 32px;">
            <h3 style="font-size: 20px; display:flex; align-items:center; gap:8px;">
                <span style="font-size:24px;"><img src="{{ asset('setting.png') }}" alt="Settings" style="width: 24px; height: 24px; object-fit: contain; vertical-align: middle;"></span> Pengaturan Akun
            </h3>
            <p class="sub" style="margin-bottom:0; font-size:14px; color:var(--ink-soft);">Perbarui informasi profil dan amankan akun Anda dengan kata sandi yang kuat.</p>
        </div>

        <form action="{{ route('pengaturan.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <h4 style="font-size:16px; margin-bottom: 16px; color:var(--ink); border-bottom: 1px solid var(--line); padding-bottom:12px;">Profil Pengguna</h4>
            
            <div class="field" style="margin-bottom: 18px;">
                <label>Nama Lengkap (PIC)</label>
                <input type="text" name="nama" value="{{ old('nama', Auth::user()->nama) }}" placeholder="Masukkan nama lengkap" required>
            </div>
            
            <div class="field" style="margin-bottom: 24px;">
                <label>Email Akses</label>
                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" placeholder="contoh@koperasi.com" required>
                <div class="helper">Email ini digunakan untuk login ke sistem Recap Support Tracker.</div>
            </div>

            <h4 style="font-size:16px; margin-bottom: 16px; margin-top: 32px; color:var(--ink); border-bottom: 1px solid var(--line); padding-bottom:12px;">Keamanan (Opsional)</h4>
            
            <div class="field" style="margin-bottom: 18px;">
                <label>Kata Sandi Saat Ini</label>
                <input type="password" name="current_password" placeholder="Masukkan kata sandi lama">
                <div class="helper">Kosongkan jika Anda tidak ingin mengubah kata sandi.</div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                <div class="field">
                    <label>Kata Sandi Baru</label>
                    <input type="password" name="password" placeholder="Minimal 8 karakter">
                </div>
                
                <div class="field">
                    <label>Konfirmasi Kata Sandi Baru</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru">
                </div>
            </div>

            <h4 style="font-size:16px; margin-bottom: 16px; margin-top: 32px; color:var(--ink); border-bottom: 1px solid var(--line); padding-bottom:12px;">Preferensi Notifikasi</h4>
            
            <div style="background: var(--paper-sunken); padding: 16px; border-radius: 8px; border: 1px solid var(--line); margin-bottom: 32px;">
                <label style="display: flex; align-items: center; justify-content: space-between; cursor: pointer;">
                    <div>
                        <div style="font-weight: 600; color: var(--ink); font-size: 14.5px;">Pemberitahuan Email</div>
                        <div style="font-size: 13px; color: var(--text-muted); margin-top:4px;">Kirim pemberitahuan ke email saat ada pembaruan tiket.</div>
                    </div>
                    <div>
                        <input type="checkbox" checked class="toggle-switch">
                    </div>
                </label>
            </div>

            <div style="border-top: 1px solid var(--line); padding-top: 20px; display: flex; justify-content: flex-end;">
                <button type="submit" class="btn btn-primary" style="padding: 10px 24px; font-weight: 600;">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
