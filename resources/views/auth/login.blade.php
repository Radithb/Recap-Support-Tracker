@extends('layouts.app')

@section('content')
<div class="login-wrap">
    <div class="site-nav">
        <div class="wm"><img src="{{ asset('logo.png') }}" alt="Logo" style="width: 24px; height: 24px; object-fit: contain;">Recap Support Tracker</div>
        <div class="site-nav-links">
            <span>Beranda</span><span>Mitra Kami</span><span>Bantuan</span>
        </div>
        <div class="site-nav-tag">Ekosistem SAKTI.Link / SiCUNDO — PT Sakti Kinerja Kolaborasindo</div>
    </div>

    <div class="login-stage">
        <div class="login-box">
            <div class="login-brandmark">
                <div class="lg">
                    <img src="{{ asset('logo.png') }}" alt="Logo" style="width: 46px; height: 46px; object-fit: contain;">
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
                    <div id="login-error" class="alert-dismiss" style="text-align: left; margin-bottom: 18px; font-weight: 500; color: var(--amber); background: var(--amber-soft); padding: 12px; border-radius: 8px; display: flex; justify-content: space-between; align-items: flex-start; transition: opacity 0.6s ease, transform 0.6s ease;">
                        <div>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                        <button type="button" onclick="document.getElementById('login-error').style.display='none'" style="background: none; border: none; color: var(--amber); cursor: pointer; font-size: 18px; font-weight: bold; line-height: 1; padding: 0 4px; margin-left: 10px;">&times;</button>
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
