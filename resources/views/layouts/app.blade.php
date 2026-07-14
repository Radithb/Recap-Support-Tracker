<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recap Support Tracker</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Load Chart.js for Reporting -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    @auth
    <nav class="navbar">
        <div class="logo">
            <h2 style="margin: 0; background: linear-gradient(to right, #4F46E5, #10b981); -webkit-background-clip: text; color: transparent;">Recap Support</h2>
        </div>
        <div class="nav-links">
            <span>Halo, {{ Auth::user()->nama }} ({{ Auth::user()->role }})</span>
            @if(Auth::user()->role === \App\Enums\UserRole::SUPPORT->value)
                <a href="{{ route('support.dashboard') }}">Board</a>
                <a href="{{ route('support.recap') }}">Analytics</a>
                <a href="{{ route('support.master-data.index') }}">Master Data</a>
            @else
                <a href="{{ route('pelapor.dashboard') }}">Dashboard</a>
            @endif
            <form action="{{ route('logout') }}" method="POST" style="display:inline; margin-left: 1.5rem;">
                @csrf
                <button type="submit" style="background:none; border:none; color:var(--danger); cursor:pointer; font-weight:600;">Logout</button>
            </form>
        </div>
    </nav>
    @endauth

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">
                <ul style="margin-left: 1.5rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
