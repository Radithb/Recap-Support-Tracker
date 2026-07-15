@extends('layouts.app')

@section('content')
<div class="login-wrap">
    <div class="site-nav">
        <div class="wm"><span class="dot"></span>Recap Support Tracker</div>
        <div class="site-nav-links">
            <span>Beranda</span><span>Mitra Kami</span><span>Bantuan</span>
        </div>
        <div class="site-nav-tag">Ekosistem SAKTI.Link / SiCUNDO — PT Sakti Kinerja Kolaborasindo</div>
    </div>

    <div class="login-stage">
        <div class="login-box">
            <div class="login-brandmark">
                <div class="lg">
                    <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="40" height="40" rx="10" fill="url(#paint0_linear)"/>
                        <path d="M13 23C13 23 16.5 21 20 21C23.5 21 27 23 27 23" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                        <path d="M20 18C21.6569 18 23 16.6569 23 15C23 13.3431 21.6569 12 20 12C18.3431 12 17 13.3431 17 15C17 16.6569 18.3431 18 20 18Z" fill="white"/>
                        <defs>
                            <linearGradient id="paint0_linear" x1="0" y1="0" x2="40" y2="40" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#DC3545"/>
                                <stop offset="1" stop-color="#1E4B8F"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="tx">
                    <strong>Recap Support Tracker</strong>
                    <span>PT SAKTI KINERJA KOLABORASINDO</span>
                </div>
            </div>

            <div class="login-panel-card">
                <p class="eyebrow">Masuk ke Akun</p>
                <h1>Login</h1>
                <p class="lede">Masukkan email dan kata sandi Anda.</p>

                {{-- Tampilkan error login --}}
                @if($errors->any())
                    <div style="text-align: left; margin-bottom: 18px; font-weight: 500; color: var(--amber); background: var(--amber-soft); padding: 12px; border-radius: 8px;">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="field">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="nama@koperasi.id" required>
                    </div>
                    <div class="field">
                        <label>Kata Sandi</label>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">Masuk ke Dashboard</button>
                </form>

                <div class="register-prompt">
                    Sudah mempunyai akun? Jika belum, <a href="{{ route('register') }}">segera daftar</a>
                </div>
            </div>
            
            <div class="login-partners">
                <span>SAKTI Online</span><span>SiCUNDO</span><span>ISO 27001:2022</span>
            </div>
        </div>
    </div>
</div>
@endsection
