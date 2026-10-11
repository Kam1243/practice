<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>URL Shortener</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <style>nav {display:flex;justify-content:space-between;align-items:center;padding:8px 0}</style>
    </head>
<body>
    <div class="container">
        <nav>
            <div><a href="/">Home</a> | <a href="/dashboard">Dashboard</a></div>
            <div>
                @auth
                    <span>{{ auth()->user()->name }} ({{ auth()->user()->role->name ?? 'NoRole' }})</span>
                    <form style="display:inline" method="POST" action="{{ route('logout') }}">@csrf<button>Logout</button></form>
                @else
                    <a href="/login">Login</a>
                @endauth
            </div>
        </nav>

        @if(session('status'))<div style="background:#dfd;padding:8px">{{ session('status') }}</div>@endif
        @yield('content')
    </div>
</body>
</html>
