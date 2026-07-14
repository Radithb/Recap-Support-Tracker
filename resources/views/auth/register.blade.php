@extends('layouts.app')

@section('content')
<div class="auth-wrapper" style="margin-top: -80px;">
    <div class="glass-panel" style="width: 100%; max-width: 400px;">
        <h2 style="text-align: center; margin-bottom: 2rem;">Registrasi Pelapor</h2>
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama') }}" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Daftar</button>
        </form>
        <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem;">
            Sudah punya akun? <a href="{{ route('login') }}" style="color: var(--primary);">Login di sini</a>
        </p>
    </div>
</div>
@endsection
