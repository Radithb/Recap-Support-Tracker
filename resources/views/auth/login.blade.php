@extends('layouts.app')

@section('content')
<div class="login-wrap">
    {{-- ═══════════════════════════════════════════ --}}
    {{-- SKELETON LOADING STATE                      --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="skeleton-wrap" id="skeleton-loading" style="width: 100%; display: flex; flex-direction: column; min-height: 100vh;">
        <div style="padding: 16px 24px; border-bottom: 1px solid var(--line); display: flex; align-items: center; justify-content: space-between; background: var(--paper);">
            <div class="skel" style="width: 200px; height: 24px; border-radius: 4px;"></div>
            <div class="skel" style="width: 350px; height: 16px; border-radius: 4px;"></div>
        </div>
        <div class="login-stage" style="flex: 1; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 40px 20px;">
            <div class="login-box" style="width: 100%; max-width: 440px;">
                <div style="display: flex; align-items: center; justify-content: center; gap: 14px; margin-bottom: 30px;">
                    <div class="skel" style="width: 46px; height: 46px; border-radius: 8px;"></div>
                    <div style="display: flex; flex-direction: column; gap: 6px; align-items: flex-start;">
                        <div class="skel" style="width: 180px; height: 18px; border-radius: 4px;"></div>
                        <div class="skel" style="width: 220px; height: 12px; border-radius: 4px;"></div>
                    </div>
                </div>
                <div class="login-panel-card" style="padding: 32px; background: var(--paper-raised); border-radius: 16px; border: 1px solid var(--line); box-shadow: 0 12px 32px rgba(27,27,24,0.04);">
                    <div class="skel" style="width: 100px; height: 12px; border-radius: 4px; margin-bottom: 8px;"></div>
                    <div class="skel" style="width: 160px; height: 28px; border-radius: 6px; margin-bottom: 8px;"></div>
                    <div class="skel" style="width: 240px; height: 14px; border-radius: 4px; margin-bottom: 32px;"></div>
                    <div class="skel" style="width: 100%; height: 60px; border-radius: 8px; margin-bottom: 16px;"></div>
                    <div class="skel" style="width: 100%; height: 60px; border-radius: 8px; margin-bottom: 24px;"></div>
                    <div class="skel" style="width: 100%; height: 48px; border-radius: 8px; margin-bottom: 24px;"></div>
                    <div class="skel" style="width: 80%; height: 14px; border-radius: 4px; margin: 0 auto;"></div>
                </div>
                <div style="display: flex; justify-content: center; gap: 12px; margin-top: 24px;">
                    <div class="skel" style="width: 80px; height: 12px; border-radius: 4px;"></div>
                    <div class="skel" style="width: 60px; height: 12px; border-radius: 4px;"></div>
                    <div class="skel" style="width: 90px; height: 12px; border-radius: 4px;"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- ACTUAL CONTENT                              --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="content-wrap" id="actual-content" style="width: 100%; display: flex; flex-direction: column; min-height: 100vh;">
        <div class="site-nav fade-up" style="animation-delay: 0.1s;">
            <div class="wm"><img src="{{ asset('logo.png') }}" alt="Logo" style="width: 24px; height: 24px; object-fit: contain;">Recap Support Tracker</div>
            <div class="site-nav-tag">Ekosistem SAKTI.Link / SiCUNDO — PT Sakti Kinerja Kolaborasindo</div>
        </div>

        <div class="login-stage">
            <div class="login-box fade-up" style="animation-delay: 0.15s;">
                <div class="login-brandmark">
                    <div class="lg">
                        <img src="{{ asset('logo.png') }}" alt="Logo" style="width: 46px; height: 46px; object-fit: contain;">
                    </div>
                    <div class="tx">
                        <strong>Recap Support Tracker</strong>
                        <span>PT SAKTI KINERJA KOLABORASINDO</span>
                    </div>
                </div>

                <div class="login-panel-card fade-up" style="animation-delay: 0.2s;">
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
                
                <div class="login-partners fade-up" style="animation-delay: 0.25s;">
                    <span>SAKTI Online</span><span>SiCUNDO</span><span>ISO 27001:2022</span>
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
            content.classList.add('loaded');
        }, 800);
    });
</script>
@endsection
