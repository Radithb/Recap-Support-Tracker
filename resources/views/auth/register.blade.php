@extends('layouts.app')

@section('content')
<div class="login-wrap">
    {{-- ═══════════════════════════════════════════ --}}
    {{-- SKELETON LOADING STATE                      --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="skeleton-wrap" id="skeleton-loading" style="width: 100%; display: flex; flex-direction: column; min-height: 100vh;">
        <div class="login-stage" style="flex: 1; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 40px 20px;">
            <div class="login-box" style="width: 100%; max-width: 640px;">
                <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 30px; padding: 0 10px;">
                    <div class="skel" style="width: 44px; height: 44px; border-radius: 8px;"></div>
                    <div style="display: flex; flex-direction: column; gap: 6px; align-items: flex-start;">
                        <div class="skel" style="width: 180px; height: 18px; border-radius: 4px;"></div>
                        <div class="skel" style="width: 220px; height: 12px; border-radius: 4px;"></div>
                    </div>
                </div>
                <div class="login-panel-card" style="padding: 32px; background: var(--paper-raised); border-radius: 16px; border: 1px solid var(--line); box-shadow: 0 12px 32px rgba(27,27,24,0.04);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 24px;">
                        <div>
                            <div class="skel" style="width: 200px; height: 26px; border-radius: 6px; margin-bottom: 8px;"></div>
                            <div class="skel" style="width: 260px; height: 14px; border-radius: 4px;"></div>
                        </div>
                        <div class="skel" style="width: 24px; height: 24px; border-radius: 4px;"></div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                        <div class="skel" style="height: 60px; border-radius: 8px;"></div>
                        <div class="skel" style="height: 60px; border-radius: 8px;"></div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                        <div class="skel" style="height: 60px; border-radius: 8px;"></div>
                        <div class="skel" style="height: 60px; border-radius: 8px;"></div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 32px;">
                        <div class="skel" style="height: 60px; border-radius: 8px;"></div>
                        <div class="skel" style="height: 60px; border-radius: 8px;"></div>
                    </div>

                    <div class="skel" style="width: 80%; height: 14px; border-radius: 4px; margin-bottom: 24px;"></div>

                    <div style="display: flex; gap: 12px;">
                        <div class="skel" style="flex: 1; height: 44px; border-radius: 8px;"></div>
                        <div class="skel" style="flex: 1; height: 44px; border-radius: 8px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- ACTUAL CONTENT                              --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="content-wrap" id="actual-content" style="width: 100%; display: none; flex-direction: column; min-height: 100vh;">
        <div class="login-stage">
            <div class="login-box fade-up" style="max-width:640px; animation-delay: 0.1s;">
                <div class="login-brandmark">
                    <img src="{{ asset('logo.png') }}" alt="Logo" style="width: 44px; height: 44px; object-fit: contain;">
                    <div class="tx"><strong>Recap Support Tracker</strong><span>PT SAKTI KINERJA KOLABORASINDO</span></div>
                </div>

                <div class="login-panel-card fade-up" style="text-align:left; animation-delay: 0.2s;">
                    {{-- Header --}}
                    <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:22px;">
                        <div>
                            <h1 style="font-family:var(--font-display); font-size: calc(22px * var(--text-scale, 1)); font-weight:600; margin:0 0 4px; color:var(--ink);">{{ __('messages.daftar_akun_baru') }}</h1>
                            <p style="margin:0; font-size: calc(13px * var(--text-scale, 1)); color:var(--ink-soft); font-family:var(--font-mono);">{{ __('messages.untuk_perwakilan') }}</p>
                        </div>
                        <a href="{{ route('login') }}" style="color:var(--ink-soft); font-size: calc(20px * var(--text-scale, 1)); text-decoration:none; line-height:1;" title="{{ __('messages.kembali_ke_login') }}">&times;</a>
                    </div>

                    {{-- Flash message sukses --}}
                    @if(session('success'))
                        <div id="register-success" class="alert-dismiss" style="display: flex; justify-content: space-between; align-items: center; padding: 12px 14px; background: var(--sage-soft); color: var(--sage); border-radius: 8px; margin-bottom: 18px; font-size: calc(13px * var(--text-scale, 1)); font-weight: 600; border: 1px solid rgba(46, 125, 82, 0.2); transition: opacity 0.6s ease, transform 0.6s ease;">
                            <span>{{ session('success') }}</span>
                            <button type="button" onclick="document.getElementById('register-success').style.display='none'" style="background: none; border: none; color: var(--sage); cursor: pointer; font-size: calc(18px * var(--text-scale, 1)); font-weight: bold; line-height: 1; padding: 0 4px; margin-left: 10px;">&times;</button>
                        </div>
                    @endif

                    {{-- Flash message error global --}}
                    @if(session('error'))
                        <div id="register-error" class="alert-dismiss" style="display: flex; justify-content: space-between; align-items: center; padding: 12px 14px; background: var(--amber-soft); color: var(--amber); border-radius: 8px; margin-bottom: 18px; font-size: calc(13px * var(--text-scale, 1)); font-weight: 600; border: 1px solid rgba(220, 53, 69, 0.2); transition: opacity 0.6s ease, transform 0.6s ease;">
                            <span>{{ session('error') }}</span>
                            <button type="button" onclick="document.getElementById('register-error').style.display='none'" style="background: none; border: none; color: var(--amber); cursor: pointer; font-size: calc(18px * var(--text-scale, 1)); font-weight: bold; line-height: 1; padding: 0 4px; margin-left: 10px;">&times;</button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- Baris 1: Nama Koperasi & Nama PIC --}}
                        <div class="register-grid">
                            <div class="field {{ $errors->has('nama_instansi') ? 'field-error' : '' }}">
                                <label for="nama_instansi">{{ __('messages.nama_koperasi_instansi') }}</label>
                                <input type="text" id="nama_instansi" name="nama_instansi" value="{{ old('nama_instansi') }}" placeholder="{{ __('messages.cth_koperasi') }}" required>
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
                                <label for="no_hp">{{ __('messages.no_hp_whatsapp') }}</label>
                                <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xx-xxxx-xxxx" required>
                                @error('no_hp')
                                    <span class="field-error-msg">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Baris 3: {{ __('messages.password') }} & Konfirmasi --}}
                        <div class="register-grid">
                            <div class="field {{ $errors->has('password') ? 'field-error' : '' }}">
                                <label for="password">{{ __('messages.password') }}</label>
                                <input type="password" id="password" name="password" placeholder="{{ __('messages.min_8_karakter') }}" required>
                                @error('password')
                                    <span class="field-error-msg">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="field {{ $errors->has('password_confirmation') ? 'field-error' : '' }}">
                                <label for="password_confirmation">Konfirmasi {{ __('messages.password') }}</label>
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
                            <a href="{{ route('login') }}" class="btn btn-ghost" style="flex:1; justify-content:center;">{{ __('messages.sudah_punya_akun') }} Masuk</a>
                            <button type="submit" class="btn btn-primary" style="flex:1; justify-content:center;">Daftar Akun</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const skeleton = document.getElementById('skeleton-loading');
        const content  = document.getElementById('actual-content');
        setTimeout(function () {
            skeleton.style.display = 'none';
            content.style.display = 'flex';
            content.classList.add('loaded');
        }, 800);
    });
</script>
@endsection
