<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recap Support Tracker</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,500;12..96,600;12..96,700;12..96,800&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,500&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

@if(Auth::check() && !request()->is('login') && !request()->is('register'))
<div class="app-shell">
    <div class="sidebar">
        <div class="sidebar-brand">
            <div class="lg">
                <!-- Placeholder untuk logo -->
                <img src="{{ asset('logo.png') }}" alt="Logo" style="width: 40px; height: 40px; object-fit: contain;">
            </div>
            <div class="tx">
                <strong>Recap Support</strong>
                @if(Auth::check() && Auth::user()->role === \App\Enums\UserRole::SUPPORT)
                    <span style="text-transform: uppercase;">TRACKER &bull; TIM SUPPORT</span>
                @else
                    <span>Tracker System</span>
                @endif
            </div>
        </div>
        
        <div class="sidebar-menu">
            @if(Auth::check() && Auth::user()->role === \App\Enums\UserRole::SUPPORT)
                <a href="{{ route('support.dashboard') }}" class="{{ request()->routeIs('support.dashboard') ? 'active' : '' }}">
                    <span class="ic"><img src="{{ asset('analysis.png') }}" alt=""></span> Dashboard
                </a>
                <a href="{{ route('support.master-data.index') }}" class="{{ request()->routeIs('support.master-data.*') ? 'active' : '' }}">
                    <span class="ic"><img src="{{ asset('folder.png') }}" alt=""></span> Master Data
                </a>
                <a href="{{ route('support.recap') }}" class="{{ request()->routeIs('support.recap') ? 'active' : '' }}">
                    <span class="ic"><img src="{{ asset('file.png') }}" alt=""></span> Rekap Support
                </a>
                
                <div style="margin-top: 20px; padding-top: 10px; border-top: 1px solid rgba(255,255,255,0.1);"></div>
                <a href="#">
                    <span class="ic"><img src="{{ asset('setting.png') }}" alt=""></span> Pengaturan
                </a>

            @else
                @yield('sidebar_menu')
                
                <div style="margin-top: 20px; padding-top: 10px; border-top: 1px solid rgba(255,255,255,0.1);"></div>
                <a href="#">
                    <span class="ic"><img src="{{ asset('setting.png') }}" alt=""></span> Pengaturan
                </a>
            @endif
        </div>
        
        <div class="sidebar-foot">
            <button class="sidebar-foot-trigger" onclick="toggleProfilePopover(event)">
                <div class="av">{{ substr(Auth::user()->nama ?? 'A', 0, 1) }}</div>
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
                        <span class="ic"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; opacity: 0.9;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg></span> Profil Saya
                    @else
                        <span class="ic"><img src="{{ asset('company.png') }}" alt="Company" style="width: 16px; height: 16px; object-fit: contain; vertical-align: middle; filter: brightness(0) invert(1); opacity: 0.9;"></span> Profil Instansi
                    @endif
                </button>
                <div class="pop-div"></div>
                <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" class="danger">
                        <span class="ic"><img src="{{ asset('logout.png') }}" alt="Logout" style="width: 16px; height: 16px; object-fit: contain; vertical-align: middle;"></span> Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="app-main">
        <div class="app-topbar">
            <div>
                <h1>@yield('page_title', 'Dashboard')</h1>
                <div class="tag">@yield('page_subtitle', 'Recap Support Tracker')</div>
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


<script>
    // Toggle Profile Popover in Sidebar
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
</script>
</body>
</html>
