@extends('layouts.app')

@section('page_title', 'Profil Saya')
@section('page_subtitle', 'Recap Support Tracker')

@section('sidebar_menu')
    <a href="{{ route('support.dashboard') }}">
        <span class="ic"><img src="{{ asset('analysis.png') }}" alt=""></span> Beranda Support
    </a>
    <a href="{{ route('support.recap') }}">
        <span class="ic"><img src="{{ asset('file.png') }}" alt=""></span> Rekapitulasi
    </a>
    <a href="{{ route('support.master-data.index') }}">
        <span class="ic"><img src="{{ asset('folder.png') }}" alt=""></span> Master Data
    </a>
@endsection

@section('content')
<div class="pelapor-panel">

    {{-- ═══════════════════════════════════════════ --}}
    {{-- SKELETON LOADING STATE                      --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="skeleton-wrap" id="skeleton-loading">
        <div class="skel" style="width: 180px; height: 36px; border-radius: 8px; margin-bottom: 24px;"></div>
        <div class="skel-panel" style="padding: 30px; max-width: 100%;">
            <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom: 24px;">
                <div>
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom: 8px;">
                        <div class="skel" style="width: 28px; height: 28px; border-radius: 6px;"></div>
                        <div class="skel" style="width: 180px; height: 24px; border-radius: 4px;"></div>
                    </div>
                    <div class="skel" style="width: 280px; height: 14px; border-radius: 4px;"></div>
                </div>
            </div>
            
            <div style="margin-bottom: 24px;">
                <div class="skel" style="width: 100px; height: 12px; margin-bottom:6px; border-radius: 4px;"></div>
                <div class="skel" style="width: 240px; height: 18px; border-radius: 4px;"></div>
            </div>
            <div style="margin-bottom: 24px;">
                <div class="skel" style="width: 100px; height: 12px; margin-bottom:6px; border-radius: 4px;"></div>
                <div class="skel" style="width: 400px; height: 16px; border-radius: 4px; margin-bottom: 4px;"></div>
                <div class="skel" style="width: 320px; height: 16px; border-radius: 4px;"></div>
            </div>
            <div style="margin-bottom: 32px;">
                <div class="skel" style="width: 100px; height: 12px; margin-bottom:6px; border-radius: 4px;"></div>
                <div class="skel" style="width: 180px; height: 16px; border-radius: 4px;"></div>
            </div>
            
            <div style="border-top: 1px solid var(--line); padding-top: 20px;">
                <div class="skel" style="width: 160px; height: 36px; border-radius: 8px;"></div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- ACTUAL CONTENT                              --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="content-wrap" id="actual-content" style="display: none;">
        
        <div class="fade-up" style="margin-bottom: 24px; animation-delay: 0.1s;">
            <a href="{{ route('support.dashboard') }}" class="btn btn-ghost" style="padding: 8px 16px; border: 1px solid var(--line); background: var(--paper-raised);">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="display:inline-block; margin-right: 6px; vertical-align:-2px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
        
        <div class="panel fade-up" style="padding: 30px; max-width: 100%; animation-delay: 0.15s;" id="instansi-panel">
            <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom: 24px;">
                <div>
                    <h3 style="display:flex; align-items:center; gap:8px; margin-bottom: 8px;">
                        <span style="font-size: calc(24px * var(--text-scale, 1));">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        </span> Profil Saya
                    </h3>
                    <p class="sub" style="margin-bottom:0;">Data dan Informasi Akun Support Anda</p>
                </div>
            </div>
            
            @if(session('success'))
                <div id="success-alert" class="alert-dismiss fade-up" style="animation-delay: 0.2s; display: flex; justify-content: space-between; align-items: center; padding: 12px 14px; background: var(--sage-soft); color: var(--sage); border-radius: 8px; margin-bottom: 24px; font-size: calc(13.5px * var(--text-scale, 1)); font-weight: 600; border: 1px solid rgba(46, 125, 82, 0.2); transition: opacity 0.6s ease, transform 0.6s ease;">
                    <span>{{ session('success') }}</span>
                    <button type="button" onclick="document.getElementById('success-alert').style.display='none'" style="background: none; border: none; color: var(--sage); cursor: pointer; font-size: calc(18px * var(--text-scale, 1)); font-weight: bold; line-height: 1; padding: 0 4px; margin-left: 10px;">&times;</button>
                </div>
            @endif
            
            @if($errors->any())
                <div id="error-alert" class="alert-dismiss fade-up" style="animation-delay: 0.2s; display: flex; justify-content: space-between; align-items: center; padding: 12px 14px; background: #fee2e2; color: #dc2626; border-radius: 8px; margin-bottom: 24px; font-size: calc(13.5px * var(--text-scale, 1)); font-weight: 600; border: 1px solid rgba(220, 38, 38, 0.2);">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" onclick="document.getElementById('error-alert').style.display='none'" style="background: none; border: none; color: #dc2626; cursor: pointer; font-size: calc(18px * var(--text-scale, 1)); font-weight: bold; line-height: 1; padding: 0 4px; margin-left: 10px;">&times;</button>
                </div>
            @endif

            <!-- VIEW MODE -->
            <div id="view-mode" class="fade-up" style="animation-delay: 0.25s;">
                <div style="margin-bottom: 24px;">
                    <label style="display:block; font-size: calc(12px * var(--text-scale, 1)); font-weight:600; color:var(--ink-soft); margin-bottom:6px;">Nama Lengkap</label>
                    <h4 style="font-size: calc(16px * var(--text-scale, 1)); color: var(--ink); margin: 0;">{{ Auth::user()->nama ?? '-' }}</h4>
                </div>
                <div style="margin-bottom: 24px;">
                    <label style="display:block; font-size: calc(12px * var(--text-scale, 1)); font-weight:600; color:var(--ink-soft); margin-bottom:6px;">Email Utama</label>
                    <p class="mono" style="color: var(--ink); line-height: 1.6; margin: 0; font-size: calc(14.5px * var(--text-scale, 1));">{{ Auth::user()->email ?? '-' }}</p>
                </div>
                <div style="margin-bottom: 32px;">
                    <label style="display:block; font-size: calc(12px * var(--text-scale, 1)); font-weight:600; color:var(--ink-soft); margin-bottom:6px;">Kata Sandi (Password)</label>
                    <div style="color: var(--text-muted); font-size: calc(14.5px * var(--text-scale, 1)); font-style: italic;">******** (Tersembunyi)</div>
                </div>
                
                <div style="border-top: 1px solid var(--line); padding-top: 20px;">
                    <button type="button" class="btn btn-ghost" onclick="toggleEditMode(true)" style="padding: 9px 18px;">
                        <span class="ic"><img src="{{ asset('edit.png') }}" alt="Edit" style="width: 14px; height: 14px; object-fit: contain; vertical-align: middle; margin-right: 4px; margin-top: -2px;"></span> Edit Profil Saya
                    </button>
                </div>
            </div>

            <!-- EDIT MODE -->
            <div id="edit-mode" style="display: none;">
                <form action="{{ route('support.profil.saya.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="field">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ Auth::user()->nama ?? '' }}" required placeholder="Masukkan nama lengkap Anda">
                    </div>
                    
                    <div class="field" style="margin-top: 18px;">
                        <label>Email Utama</label>
                        <input type="email" name="email" value="{{ Auth::user()->email ?? '' }}" required placeholder="Masukkan email aktif Anda">
                    </div>
                    
                    <div class="field" style="margin-top: 18px; border-top: 1px dashed var(--line); padding-top: 18px;">
                        <label>Kata Sandi Saat Ini</label>
                        <input type="password" name="current_password" placeholder="Masukkan kata sandi saat ini (wajib jika ingin mengubah password)">
                        <div class="helper">Wajib diisi sebagai verifikasi keamanan sebelum Anda mengubah kata sandi.</div>
                    </div>
                    
                    <div class="field" style="margin-top: 18px;">
                        <label>Kata Sandi Baru (Opsional)</label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                        <div class="helper">Minimal 8 karakter. Biarkan kosong jika tidak ada perubahan.</div>
                    </div>
                    
                    <div class="field" style="margin-top: 18px;">
                        <label>Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru">
                    </div>
                    
                    <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--line);">
                        <button type="button" class="btn btn-ghost" onclick="toggleEditMode(false)" style="padding: 10px 20px;">Batal</button>
                        <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function toggleEditMode(showEdit) {
                document.getElementById('view-mode').style.display = showEdit ? 'none' : 'block';
                document.getElementById('edit-mode').style.display = showEdit ? 'block' : 'none';
            }

            document.addEventListener('DOMContentLoaded', function () {
                const skeleton = document.getElementById('skeleton-loading');
                const content  = document.getElementById('actual-content');
                // Auto show edit mode if there are errors
                @if($errors->any())
                    toggleEditMode(true);
                @endif
                
                if(skeleton && content) {
                    setTimeout(function () {
                        skeleton.style.display = 'none';
                        content.style.display = 'block';
                        content.classList.add('loaded');
                    }, 400);
                }
            });
        </script>
        
    </div>
</div>
@endsection
