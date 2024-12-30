<!-- navbar_web.blade.php -->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
    <div class="container col-lg-12 col-xl-6">
        <a class="navbar-brand fw-bold text-uppercase" href="{{ url('/') }}">
            <i class="fas fa-book-open me-2"></i>TUKUBUKU
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                </li>

                @auth
                <li class="nav-item position-relative">
                    <a class="nav-link" href="{{ route('cart.index') }}">
                        <i class="mdi mdi-cart"></i>
                        <span class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle"
                            style="font-size: 10px;">
                            {{ $cartTotal }} <!-- Menampilkan jumlah item di keranjang -->
                        </span>
                    </a>
                </li>
                @endauth

                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt me-1"></i>Login
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">
                        <i class="fas fa-user-plus me-1"></i>Register
                    </a>
                </li>
                @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        @if(Auth::user()->hasRole('admin'))
                        <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                        @endif
                        @if(Auth::user()->hasRole('customer'))
                        <li><a class="dropdown-item" href="{{ route('customers.dashboard') }}">Member Dashboard</a></li>
                        @endif
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-1"></i>Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>