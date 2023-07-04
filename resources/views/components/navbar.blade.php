<nav class="navbar navbar-expand-xl navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('images/aulab.png') }}" alt="Logo" width="200" height="200">
        </a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0 container" style="display: flex; justify-content:start;">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('articles.index') }}">Articles</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('careers') }}">Careers</a>
        </li>
        @auth
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 1.35rem; margin-bottom: -10px;">
                Colaborador
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                
                    <li><a class="dropdown-item" href="{{ route('articles.create') }}">Create Article</a></li>
                    @if(auth()->user()->is_admin || auth()->user()->is_revisor)
                        <li><a class="dropdown-item" href="{{ route('dashboardrev') }}">Revisor visibility</a></li>
                    @endif
                    @if(auth()->user()->is_admin == 1)
                        <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard Admin</a></li>
                    @endif
                @endauth
            </ul>
        </li>
    </ul>
    <ul class="navbar-nav ms-2">
        @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">Register</a>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="font-size: 1rem; margin-bottom: -10px;">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        @endguest
    </ul>
    <form class="d-flex" action="{{ route('search') }}" method="GET" style="margin-bottom: -5px;">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
</div>
</div>
</nav>