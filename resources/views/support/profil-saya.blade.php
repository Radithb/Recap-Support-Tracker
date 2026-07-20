@extends('layouts.app')

@section('page_title', 'Profil Saya')
@section('page_subtitle', 'Recap Support Tracker')

@section('sidebar_menu')
    <a href="{{ route('support.dashboard') }}">
        <span class="ic"><img src="{{ asset('analysis.png') }}" alt=""></span> {{ __('messages.beranda_support') }}
    </a>
    <a href="{{ route('support.recap') }}">
        <span class="ic"><img src="{{ asset('file.png') }}" alt=""></span> {{ __('messages.rekapitulasi') }}
    </a>
    <a href="{{ route('support.master-data.index') }}">
        <span class="ic"><img src="{{ asset('folder.png') }}" alt=""></span> {{ __('messages.master_data') }}
    </a>
@endsection

@section('content')
<div class="pelapor-panel">

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
            background: var(--sage, #22c55e);
        }
        .toggle-switch::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: 16px;
            height: 16px;
            background: var(--paper-raised, #fff);
            border-radius: 50%;
            transition: transform 0.3s ease;
        }
        .toggle-switch:checked::after {
            transform: translateX(20px);
        }
    </style>

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
                {{ __('messages.kembali_ke_dashboard') }}
            </a>
        </div>

        <!-- HEADER -->
        <div class="fade-up" style="margin-bottom: 24px; animation-delay: 0.12s;">
            <div style="font-size: 11px; letter-spacing: 1px; color: var(--ink-soft); text-transform: uppercase; margin-bottom: 4px; font-weight: 600;">
                TIM SUPPORT &middot; {{ Auth::user()->nama }}
            </div>
            <h2 style="margin: 0; font-size: 28px; font-weight: 700; color: var(--ink);">
                Profil Saya
            </h2>
        </div>
        
        @if(session('success'))
            <div id="success-alert" class="alert-dismiss fade-up" style="animation-delay: 0.14s; display: flex; justify-content: space-between; align-items: center; padding: 12px 14px; background: var(--sage-soft); color: var(--sage); border-radius: 8px; margin-bottom: 24px; font-size: calc(13.5px * var(--text-scale, 1)); font-weight: 600; border: 1px solid rgba(46, 125, 82, 0.2); transition: opacity 0.6s ease, transform 0.6s ease;">
                <span>{{ session('success') }}</span>
                <button type="button" onclick="document.getElementById('success-alert').style.display='none'" style="background: none; border: none; color: var(--sage); cursor: pointer; font-size: calc(18px * var(--text-scale, 1)); font-weight: bold; line-height: 1; padding: 0 4px; margin-left: 10px;">&times;</button>
            </div>
        @endif
        
        @if($errors->any())
            <div id="error-alert" class="alert-dismiss fade-up" style="animation-delay: 0.14s; display: flex; justify-content: space-between; align-items: center; padding: 12px 14px; background: #fee2e2; color: #dc2626; border-radius: 8px; margin-bottom: 24px; font-size: calc(13.5px * var(--text-scale, 1)); font-weight: 600; border: 1px solid rgba(220, 38, 38, 0.2);">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" onclick="document.getElementById('error-alert').style.display='none'" style="background: none; border: none; color: #dc2626; cursor: pointer; font-size: calc(18px * var(--text-scale, 1)); font-weight: bold; line-height: 1; padding: 0 4px; margin-left: 10px;">&times;</button>
            </div>
        @endif

        <!-- PANEL 1: INFORMASI IDENTITAS DIRI -->
        <div class="panel fade-up" style="padding: 30px; max-width: 100%; animation-delay: 0.15s; margin-bottom: 24px;">
            <h3 style="display:flex; align-items:center; gap:8px; margin-bottom: 6px; font-size: calc(16px * var(--text-scale, 1)); color: var(--ink);">
                🪪 {{ __('messages.informasi_identitas_diri') }}
            </h3>
            <p class="sub" style="margin-bottom: 24px; color: var(--ink-soft); font-size: calc(13px * var(--text-scale, 1));">
                {{ __('messages.data_pribadi_koperasi') }}
            </p>

            <form action="{{ route('support.profil.saya.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Avatar Upload Section -->
                <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 28px;">
                    <div style="position: relative; width: 70px; height: 70px; border-radius: 50%; border: 2px solid var(--line); background: var(--paper-sunken); overflow: hidden; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        @php
                            $nama = Auth::user()->nama ?? 'User';
                            $initials = collect(explode(' ', $nama))->map(function($w){return strtoupper(substr($w,0,1));})->take(2)->join('');
                        @endphp
                        @if(Auth::user()->avatar)
                            <img id="avatar-preview" src="{{ asset('storage/' . Auth::user()->avatar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <img id="avatar-preview" src="" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                            <span id="avatar-placeholder" style="font-size: 28px; font-weight: bold; color: var(--ink-soft);">{{ $initials }}</span>
                        @endif
                    </div>
                    <div>
                        <button type="button" class="btn btn-ghost" style="border: 1px solid var(--line); background: var(--paper-raised); padding: 6px 12px; font-size: 13px;" onclick="document.getElementById('avatar-input').click()">
                            📷 {{ __('messages.ganti_foto_profil') }}
                        </button>
                        <div style="font-size: 11px; color: var(--ink-soft); margin-top: 6px;">{{ __('messages.belum_ada_foto_format') }}</div>
                        <input type="file" name="avatar" id="avatar-input" style="display: none;" accept="image/*" onchange="previewAvatar(this)">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
                    <div class="field">
                        <label>{{ __('messages.nama_lengkap') }}</label>
                        <input type="text" name="nama" value="{{ Auth::user()->nama }}" required style="background: var(--paper-sunken);">
                    </div>
                    <div class="field">
                        <label>{{ __('messages.nik_id_agen') }}</label>
                        <input type="text" name="nik" value="{{ Auth::user()->nik }}" placeholder="Contoh: SKK-EMP-0417" style="background: var(--paper-sunken);">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
                    <div class="field">
                        <label>{{ __('messages.no_whatsapp_hp') }}</label>
                        <input type="text" name="whatsapp" value="{{ Auth::user()->whatsapp }}" placeholder="Contoh: +62 812 3300 4455" style="background: var(--paper-sunken);">
                    </div>
                    <div class="field">
                        <label>{{ __('messages.alamat_email') }}</label>
                        <input type="email" name="email" value="{{ Auth::user()->email }}" required style="background: var(--paper-sunken);">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="padding: 10px 20px; background: #dc2626; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">{{ __('messages.simpan_perubahan') }}</button>
            </form>
        </div>

        <!-- PANEL 2: KEAMANAN AKUN -->
        <div class="panel fade-up" style="padding: 30px; max-width: 100%; animation-delay: 0.2s; margin-bottom: 24px;">
            <h3 style="display:flex; align-items:center; gap:8px; margin-bottom: 6px; font-size: calc(16px * var(--text-scale, 1)); color: var(--ink);">
                🔒 {{ __('messages.keamanan_akun') }}
            </h3>
            <p class="sub" style="margin-bottom: 24px; color: var(--ink-soft); font-size: calc(13px * var(--text-scale, 1));">
                {{ __('messages.keamanan_akun_support_desc') }}
            </p>

            <form action="{{ route('support.profil.saya.update') }}" method="POST">
                @csrf
                @method('PUT')


                <div class="field" style="margin-bottom: 18px;">
                    <label>{{ __('messages.kata_sandi_saat_ini') }}</label>
                    <input type="password" name="current_password" style="background: var(--paper-sunken);" placeholder="••••••••">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
                    <div class="field">
                        <label>{{ __('messages.kata_sandi_baru') }}</label>
                        <input type="password" name="password" style="background: var(--paper-sunken);" placeholder="••••••••">
                    </div>
                    <div class="field">
                        <label>{{ __('messages.konfirmasi_kata_sandi') }}</label>
                        <input type="password" name="password_confirmation" style="background: var(--paper-sunken);" placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" class="btn btn-ghost" style="border: 1px solid var(--line); background: var(--paper-sunken); padding: 10px 20px; margin-bottom: 24px;">{{ __('messages.perbarui_kata_sandi') }}</button>


            </form>
        </div>



        <script>
            function previewAvatar(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.getElementById('avatar-preview');
                        const placeholder = document.getElementById('avatar-placeholder');
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                        if (placeholder) placeholder.style.display = 'none';
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                const skeleton = document.getElementById('skeleton-loading');
                const content  = document.getElementById('actual-content');
                
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
