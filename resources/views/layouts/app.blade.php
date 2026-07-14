<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recap Support Tracker</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400..800&family=Plus+Jakarta+Sans:wght@400..800&family=JetBrains+Mono:wght@400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    @if(Auth::check() && !request()->routeIs('login') && !request()->routeIs('register'))
    <div class="topnav">
        <div class="wordmark"><span class="dot"></span>Recap Support Tracker</div>
        <div class="topnav-tag">
            {{ Auth::user()->role === 'Support' ? 'internal.ptskk.id' : (Auth::user()->instansi->nama_instansi ?? 'Mitra Eksternal') }}
        </div>
        <div class="topnav-right">
            <span class="role-chip" style="{{ Auth::user()->role === 'Support' ? 'background:var(--brand-primary-soft); color:var(--indigo);' : '' }}">
                {{ Auth::user()->role }}
            </span>
            <div class="avatar" style="{{ Auth::user()->role === 'Support' ? 'background:var(--indigo); color:#fff;' : '' }}">
                {{ strtoupper(substr(Auth::user()->nama, 0, 2)) }}
            </div>
            
            <form action="{{ route('logout') }}" method="POST" style="margin-left:14px;">
                @csrf
                <button type="submit" class="btn btn-ghost btn-sm" style="color:white; border-color:rgba(255,255,255,0.3);">Keluar</button>
            </form>
        </div>
    </div>
    @endif

    <div class="page" style="{{ request()->routeIs('login') ? 'padding:0; max-width:100%;' : '' }}">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>

    <!-- Script to handle modals easily -->
    <script>
        function openModal(id) {
            document.getElementById(id).classList.add('active');
        }
        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
        }
    </script>
</body>
</html>
