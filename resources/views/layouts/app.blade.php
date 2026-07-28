<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAKTI Desk</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,700&family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,500;12..96,600;12..96,700;12..96,800&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,500&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ date('YmdHis') }}">
    <script>
        // Apply personalization before page render to prevent FOUC
        (function() {
            var theme = localStorage.getItem('personal_theme');
            if (theme === 'dark') {
                document.documentElement.classList.add('dark-mode');
            }
            var fontSize = localStorage.getItem('personal_font_size');
            if (fontSize) {
                document.documentElement.classList.add('text-' + fontSize);
            }
        })();
    </script>
</head>
<body>

@if(Auth::check() && !request()->is('login') && !request()->is('register') && !request()->is('forgot-password') && !request()->is('verify-otp') && !request()->is('reset-password'))
<div class="app-shell">
    <div class="sidebar">
        <div class="sidebar-brand">
            <div class="lg">
                <!-- Placeholder untuk logo -->
                <img src="{{ asset('logo.png') }}" alt="Logo" style="width: 40px; height: 40px; object-fit: contain;">
            </div>
            <div class="tx">
                @if(Auth::check() && Auth::user()->role === \App\Enums\UserRole::SUPPORT)
                    <strong>SAKTI Desk</strong>
                    <span style="text-transform: uppercase;">TIM SUPPORT</span>
                @else
                    <strong>SAKTI Desk</strong>
                    <span>Tracker System</span>
                @endif
            </div>
        </div>
        
        <div class="sidebar-menu">
            @if(Auth::check() && Auth::user()->role === \App\Enums\UserRole::SUPPORT)
                <a href="{{ route('support.dashboard') }}" class="{{ request()->routeIs('support.dashboard') ? 'active' : '' }}">
                    <span class="ic"><img src="{{ asset('analysis.png') }}" alt=""></span> {{ __('messages.dashboard') }}
                </a>
                <a href="{{ route('support.master-data.index') }}" class="{{ request()->routeIs('support.master-data.*') ? 'active' : '' }}">
                    <span class="ic"><img src="{{ asset('folder.png') }}" alt=""></span> {{ __('messages.master_data') }}
                </a>
                <a href="{{ route('support.recap') }}" class="{{ request()->routeIs('support.recap') ? 'active' : '' }}">
                    <span class="ic"><img src="{{ asset('file.png') }}" alt=""></span> {{ __('messages.recap_laporan') }}
                </a>
                
                <div style="margin-top: 20px; padding-top: 10px; border-top: 1px solid rgba(255,255,255,0.1);"></div>
                <a href="{{ route('pengaturan') }}" class="{{ request()->routeIs('pengaturan') ? 'active' : '' }}">
                    <span class="ic"><img src="{{ asset('setting.png') }}" alt=""></span> {{ __('messages.pengaturan') }}
                </a>

            @else
                <a href="{{ route('pelapor.dashboard') }}" class="{{ request()->routeIs('pelapor.dashboard') ? 'active' : '' }}">
                    <span class="ic"><img src="{{ asset('analysis.png') }}" alt=""></span> {{ __('messages.dashboard') }}
                </a>
                <a href="{{ route('pelapor.riwayat') }}" class="{{ request()->routeIs('pelapor.riwayat') ? 'active' : '' }}">
                    <span class="ic"><img src="{{ asset('file.png') }}" alt=""></span> {{ __('messages.riwayat_lengkap') }}
                </a>
                
                <div style="margin-top: 20px; padding-top: 10px; border-top: 1px solid rgba(255,255,255,0.1);"></div>
                <a href="{{ route('pengaturan') }}" class="{{ request()->routeIs('pengaturan') ? 'active' : '' }}">
                    <span class="ic"><img src="{{ asset('setting.png') }}" alt=""></span> {{ __('messages.pengaturan') }}
                </a>
            @endif
        </div>
        
        <div class="sidebar-foot">
            <button class="sidebar-foot-trigger" onclick="toggleProfilePopover(event)">
                <div class="av" style="overflow: hidden;">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        {{ substr(Auth::user()->nama ?? 'A', 0, 1) }}
                    @endif
                </div>
                <div class="nm">
                    <strong>{{ Auth::user()->nama ?? 'User' }}</strong>
                    <span>{{ Auth::user()->instansi->nama_instansi ?? 'Administrator' }}</span>
                </div>
            </button>
            
            <div class="profile-popover" id="profile-popover">
                <div class="pop-head">
                    <strong>{{ Auth::user()->nama ?? 'User' }}</strong>
                    <span>{{ Auth::user()->email ?? 'email@example.com' }}</span>
                </div>
                <button onclick="window.location.href='{{ Auth::check() && Auth::user()->role === \App\Enums\UserRole::SUPPORT ? route('support.profil.saya') : route('profil.instansi') }}'">
                    @if(Auth::check() && Auth::user()->role === \App\Enums\UserRole::SUPPORT)
                        <span class="ic"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; opacity: 0.9;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg></span> {{ __('messages.profil_saya') }}
                    @else
                        <span class="ic"><img src="{{ asset('company.png') }}" alt="Company" style="width: 16px; height: 16px; object-fit: contain; vertical-align: middle; filter: brightness(0) invert(1); opacity: 0.9;"></span> {{ __('messages.profil_koperasi') }}
                    @endif
                </button>
                <button onclick="window.location.href='{{ route('pengaturan') }}'">
                    <span class="ic"><img src="{{ asset('setting.png') }}" alt="Settings" style="width: 16px; height: 16px; object-fit: contain; vertical-align: middle; filter: brightness(0) invert(1); opacity: 0.9;"></span> {{ __('messages.pengaturan') }}
                </button>
                @if(Auth::check() && Auth::user()->role !== \App\Enums\UserRole::SUPPORT)
                <button onclick="window.location.href='{{ route('pelapor.bantuan') }}'">
                    <span class="ic"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; opacity: 0.9;"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg></span> {{ __('messages.title_pusat_bantuan') }}
                </button>
                @endif
                <div class="pop-div"></div>
                <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" class="danger">
                        <span class="ic"><img src="{{ asset('logout.png') }}" alt="Logout" style="width: 16px; height: 16px; object-fit: contain; vertical-align: middle;"></span> {{ __('messages.keluar_singkat') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="app-main">
        <div class="app-topbar">
            <div>
                <h1>@yield('page_title', 'Dashboard')</h1>
                @if(Auth::check() && Auth::user()->role === \App\Enums\UserRole::SUPPORT)
                    <div class="tag">@yield('page_subtitle', 'SAKTI Desk')</div>
                @else
                    <div class="tag">@yield('page_subtitle', 'SAKTI Desk')</div>
                @endif
            </div>
            <div class="app-topbar-right">
                @yield('topbar_right')
            </div>
        </div>

        @yield('content')
    </div>
</div>
@else
    @yield('content')
@endif

@if(Auth::check() && !request()->is('login') && !request()->is('register') && !request()->is('forgot-password') && !request()->is('verify-otp') && !request()->is('reset-password'))
<!-- ================= MOBILE UI COMPONENTS (TAHAP 1) ================= -->
<div class="mobile-top-header">
    <div class="m-left">
        <div class="m-title">
            <strong>@yield('page_title', 'Dashboard')</strong> / @yield('page_subtitle', 'SAKTI Desk')
        </div>
    </div>
    <div class="m-right">
        <button class="m-avatar" onclick="toggleMobileProfile(event)">
            @if(Auth::check() && Auth::user()->avatar)
                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="">
            @else
                {{ substr(Auth::user()->nama ?? 'D', 0, 1) }}
            @endif
        </button>
    </div>
</div>

<div class="mobile-profile-overlay" id="mobile-profile-overlay" onclick="toggleMobileProfile(event)"></div>
<div class="mobile-profile-popup" id="mobile-profile-popup">
    <div class="mp-head">
        <strong>{{ Auth::check() ? Auth::user()->nama : 'User' }}</strong>
        <span>{{ Auth::check() ? Auth::user()->email : 'email@example.com' }}</span>
    </div>
    <div class="mp-body">
        <button onclick="window.location.href='{{ Auth::check() && Auth::user()->role === \App\Enums\UserRole::SUPPORT ? route('support.profil.saya') : route('profil.instansi') }}'">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            Profil Saya
        </button>
        <button onclick="window.location.href='{{ route('pengaturan') }}'">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
            Pengaturan
        </button>
        @if(Auth::check() && Auth::user()->role !== \App\Enums\UserRole::SUPPORT)
        <button onclick="window.location.href='{{ route('pelapor.bantuan') }}'">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
            Pusat Bantuan
        </button>
        @endif
        <form action="{{ route('logout') }}" method="POST" style="margin:0; border-top:1px solid var(--line); padding-top:5px; margin-top:5px;">
            @csrf
            <button type="submit" class="danger">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                Keluar
            </button>
        </form>
    </div>
</div>

<div class="mobile-bottom-nav">
    @if(Auth::check() && Auth::user()->role === \App\Enums\UserRole::SUPPORT)
        <a href="{{ route('support.dashboard') }}" class="{{ request()->routeIs('support.dashboard') ? 'active' : '' }}">
            <img src="{{ asset('analysis.png') }}" alt="Dashboard">
            <span>Dashboard</span>
        </a>
        <a href="{{ route('support.master-data.index') }}" class="{{ request()->routeIs('support.master-data.*') ? 'active' : '' }}">
            <img src="{{ asset('folder.png') }}" alt="Master data">
            <span>Master data</span>
        </a>
        <a href="{{ route('support.recap') }}" class="{{ request()->routeIs('support.recap') ? 'active' : '' }}">
            <img src="{{ asset('file.png') }}" alt="Rekap">
            <span>Rekap</span>
        </a>
        <a href="{{ route('pengaturan') }}" class="{{ request()->routeIs('pengaturan') ? 'active' : '' }}">
            <img src="{{ asset('setting.png') }}" alt="Atur">
            <span>Atur</span>
        </a>
    @else
        <!-- Menu Pelapor -->
        <a href="{{ route('pelapor.dashboard') }}" class="{{ request()->routeIs('pelapor.dashboard') ? 'active' : '' }}">
            <img src="{{ asset('analysis.png') }}" alt="Dashboard">
            <span>Dashboard</span>
        </a>
        <a href="{{ route('pelapor.riwayat') }}" class="{{ request()->routeIs('pelapor.riwayat') ? 'active' : '' }}">
            <img src="{{ asset('file.png') }}" alt="Riwayat">
            <span>Riwayat</span>
        </a>
        <a href="{{ route('pengaturan') }}" class="{{ request()->routeIs('pengaturan') ? 'active' : '' }}">
            <img src="{{ asset('setting.png') }}" alt="Atur">
            <span>Atur</span>
        </a>
    @endif
</div>
@endif

<script>
    // Toggle Mobile Profile Popover
    function toggleMobileProfile(e) {
        if(e) e.stopPropagation();
        const overlay = document.getElementById('mobile-profile-overlay');
        const popup = document.getElementById('mobile-profile-popup');
        if(overlay) overlay.classList.toggle('active');
        if(popup) popup.classList.toggle('active');
    }
    function toggleProfilePopover(e) {
        e.stopPropagation();
        const pop = document.getElementById('profile-popover');
        if(pop) pop.classList.toggle('active');
    }

    // Close Profile Popover when clicking outside
    document.addEventListener('click', function(e) {
        const pop = document.getElementById('profile-popover');
        if(pop && pop.classList.contains('active') && !e.target.closest('.sidebar-foot')) {
            pop.classList.remove('active');
        }
    });

    // Generic Modal functions (will be used by panels in Phase 2)
    function openModal(id) {
        const modal = document.getElementById(id);
        if(modal) modal.classList.add('active');
    }
    
    function closeModal(id) {
        const modal = document.getElementById(id);
        if(modal) modal.classList.remove('active');
    }

    // Auto-dismiss alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert-dismiss');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.classList.add('fade-out-up');
                
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 600);
            }, 5000);
        });
    });

    // Enable Drag-to-Scroll for horizontal tables
    document.addEventListener('DOMContentLoaded', function() {
        const sliders = document.querySelectorAll('.table-scroll-wrapper');
        let isDown = false;
        let startX;
        let scrollLeft;
        let isDragging = false;

        sliders.forEach(slider => {
            slider.addEventListener('mousedown', (e) => {
                isDown = true;
                isDragging = false;
                slider.style.cursor = 'grabbing';
                startX = e.pageX - slider.offsetLeft;
                scrollLeft = slider.scrollLeft;
            });
            slider.addEventListener('mouseleave', () => {
                isDown = false;
                slider.style.cursor = '';
            });
            slider.addEventListener('mouseup', () => {
                isDown = false;
                slider.style.cursor = '';
            });
            slider.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                const x = e.pageX - slider.offsetLeft;
                const walk = (x - startX) * 1.5;
                if (Math.abs(walk) > 5) {
                    isDragging = true;
                    e.preventDefault();
                }
                slider.scrollLeft = scrollLeft - walk;
            });
            
            // Mencegah klik tombol jika pengguna sedang menggeser tabel
            slider.addEventListener('click', (e) => {
                if (isDragging) {
                    e.preventDefault();
                    e.stopPropagation();
                    isDragging = false;
                }
            }, true);
        });
    });
</script>
</body>
</html>
