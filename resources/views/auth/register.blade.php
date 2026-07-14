@extends('layouts.app')

@section('content')
<div class="login-wrap">
    <div class="login-stage">
        <div class="login-box" style="max-width:520px;">
            <div class="login-brandmark">
                <img src="{{ asset('logo.png') }}" alt="Logo" style="width: 44px; height: 44px; object-fit: contain;">
                <div class="tx"><strong>Recap Support Tracker</strong><span>PT SAKTI KINERJA KOLABORASINDO</span></div>
            </div>

            <div class="login-panel-card">
                <p class="eyebrow">Pendaftaran Akun</p>
                <h1>Daftar Pelapor</h1>
                <p class="lede">Isi data instansi dan diri Anda untuk mendaftar.</p>
                
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div style="text-align:left; font-size:13px; font-weight:700; color:var(--ink); margin:20px 0 10px;">Data Instansi</div>
                    <div class="field">
                        <label>Nama Instansi</label>
                        <input type="text" name="nama_instansi" placeholder="Misal: Koperasi Sejahtera" required>
                    </div>
                    <div class="field">
                        <label>Alamat Lengkap</label>
                        <textarea name="alamat" rows="2" placeholder="Alamat lengkap instansi" required></textarea>
                    </div>
                    <div class="field">
                        <label>Nomor Telepon Instansi</label>
                        <input type="text" name="no_telp" placeholder="08..." required>
                    </div>

                    <div style="text-align:left; font-size:13px; font-weight:700; color:var(--ink); margin:24px 0 10px; border-top:1px dashed var(--line); padding-top:20px;">Data PIC (Person In Charge)</div>
                    <div class="field">
                        <label>Nama Lengkap PIC</label>
                        <input type="text" name="nama" placeholder="Nama Anda" required>
                    </div>
                    <div class="field">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="nama@koperasi.id" required>
                    </div>
                    <div class="field">
                        <label>Kata Sandi</label>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>
                    <div class="field">
                        <label>Konfirmasi Kata Sandi</label>
                        <input type="password" name="password_confirmation" placeholder="••••••••" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center; margin-top:10px;">Daftar Sekarang</button>
                </form>
                
                <div class="register-prompt">
                    Sudah memiliki akun? <a href="{{ route('login') }}">Masuk di sini</a>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
