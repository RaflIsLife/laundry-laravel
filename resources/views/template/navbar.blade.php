<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <div class="navbar-brand">

            <a class="" href="{{ route('home') }}">
                <h3 class="fw-bold text-primary">Quick<span class="text-secondary">Wash</span></h3>
            </a>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                </li>
                @if (Auth::check())

                @if(Auth::user()->role == 'kasir')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('kasir') }}">Kasir</a>
                </li>
                @endif
                @if(Auth::user()->role == 'kurir')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('kurir') }}">Kurir</a>
                </li>
                @endif

                @if(Auth::user()->role == 'customer')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user') }}">user</a>
                </li>
                @endif

                @if(Auth::user()->role == 'admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.home') }}">admin</a>
                </li>
                @endif

                @if(Auth::user()->role == 'owner')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('owner') }}">owner</a>
                </li>
                @endif
                @endif

            </ul>
        </div>
    </div>
</nav>
