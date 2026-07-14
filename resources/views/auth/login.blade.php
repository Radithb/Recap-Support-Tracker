@extends('layouts.app')

@section('content')
<div class="login-wrap">
    <div class="login-stage">
        <div class="login-box">
            <div class="login-brandmark">
                <img src="{{ asset('logo.png') }}" alt="Logo" style="width: 44px; height: 44px; object-fit: contain;">
                <div class="tx"><strong>Recap Support Tracker</strong><span>PT SAKTI KINERJA KOLABORASINDO</span></div>
            </div>

            <div class="login-panel-card">
                <p class="eyebrow">Masuk ke Akun</p>
                <h1>Login</h1>
                <p class="lede">Masukkan email dan kata sandi Anda.</p>
                
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
