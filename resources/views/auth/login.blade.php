@extends('layouts.app')

@section('content')
<div class="auth-wrapper" style="margin-top: -80px;">
    <div class="glass-panel" style="width: 100%; max-width: 400px;">
        <h2 style="text-align: center; margin-bottom: 2rem;">Login Support</h2>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Masuk</button>
        </form>
        <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem;">
            Belum punya akun? <a href="{{ route('register') }}" style="color: var(--primary);">Daftar di sini</a>
        </p>
    </div>
</div>
@endsection
