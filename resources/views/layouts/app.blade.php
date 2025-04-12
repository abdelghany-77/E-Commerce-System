<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ config('app.name', 'E-Commerce') }} - @yield('title', 'Home')</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  {{-- custom css --}}
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  @yield('styles')
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
          <i class="fas fa-store me-2"></i>E-Shop
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}"
                aria-current="page">
                Home
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('shop.*') ? 'active' : '' }}" href="{{ route('shop.index') }}">
                Shop
              </a>
            </li>
          </ul>

          <form class="d-flex search-form me-3" action="{{ route('shop.index') }}" method="GET">
            <div class="input-group">
              <input class="form-control border-end-0" type="search" name="search" placeholder="Search products..."
                value="{{ request('search') }}">
              <button class="btn btn-outline-light" type="submit">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </form>

          <ul class="navbar-nav">
            @auth
              <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}" href="{{ route('cart.index') }}">
                  <i class="fas fa-shopping-cart"></i>
                  @php
                    $cartCount = auth()->check() ? auth()->user()->cartItems()->sum('quantity') : 0;
                  @endphp
                  @if ($cartCount > 0)
                    <span class="badge bg-danger cart-badge">{{ $cartCount }}</span>
                  @endif
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown"
                  role="button" data-bs-toggle="dropdown">
                  <i class="fas fa-user-circle me-2"></i>
                  {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  @if (Auth::user()->is_admin)
                    <li>
                      <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard
                      </a>
                    </li>
                    <li>
                      <hr class="dropdown-divider">
                    </li>
                  @endif
                  <li>
                    <a class="dropdown-item" href="{{ route('orders.index') }}">
                      <i class="fas fa-clipboard-list me-2"></i>My Orders
                    </a>
                  </li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li>
                    <form action="{{ route('logout') }}" method="POST">
                      @csrf
                      <button type="submit" class="dropdown-item">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                      </button>
                    </form>
                  </li>
                </ul>
              </li>
            @else
              <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
                  <i class="fas fa-sign-in-alt me-1"></i>Login
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">
                  <i class="fas fa-user-plus me-1"></i>Register
                </a>
              </li>
            @endauth
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <main class="py-4">
    <div class="container-xxl">
      @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center">
          <i class="fas fa-check-circle me-2"></i>
          {{ session('success') }}
          <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
      @endif

      @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center">
          <i class="fas fa-exclamation-circle me-2"></i>
          {{ session('error') }}
          <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
      @endif

      @yield('content')
    </div>
  </main>

  <footer>
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-4">
          <h5 class="mb-3 text-white"><i class="fas fa-store me-2"></i>E-Shop</h5>
          <p class="small">Quality products with fast delivery and excellent customer service.</p>
          <div class="social-links">
            <a href="#" class="text-light me-3"><i class="fab fa-facebook"></i></a>
            <a href="#" class="text-light me-3"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-light me-3"><i class="fab fa-instagram"></i></a>
          </div>
        </div>

        <div class="col-lg-4">
          <h5 class="mb-3 text-white">Quick Links</h5>
          <ul class="list-unstyled">
            <li class="mb-2">
              <a href="{{ route('home') }}" class="footer-link">
                <i class="fas fa-chevron-right me-1"></i>Home
              </a>
            </li>
            <li class="mb-2">
              <a href="{{ route('shop.index') }}" class="footer-link">
                <i class="fas fa-chevron-right me-1"></i>Shop
              </a>
            </li>
            @auth
              <li class="mb-2">
                <a href="{{ route('orders.index') }}" class="footer-link">
                  <i class="fas fa-chevron-right me-1"></i>Orders
                </a>
              </li>
            @endauth
          </ul>
        </div>

        <div class="col-lg-4">
          <h5 class="mb-3 text-white">Contact</h5>
          <ul class="list-unstyled">
            <li class="mb-2">
              <i class="fas fa-map-marker-alt me-2"></i>
              123 E-Commerce St, City, Country
            </li>
            <li class="mb-2">
              <i class="fas fa-envelope me-2"></i>
              contact@e-shop.com
            </li>
            <li class="mb-2">
              <i class="fas fa-phone me-2"></i>
              +1 234 567 8900
            </li>
          </ul>
        </div>
      </div>

      <hr class="my-4 border-light">

      <div class="row">
        <div class="col-md-6 text-center text-md-start">
          <p class="small mb-0">&copy; {{ date('Y') }} E-Shop. All rights reserved.</p>
        </div>
        <div class="col-md-6 text-center text-md-end">
          <a href="#" class="footer-link small me-3">Privacy Policy</a>
          <a href="#" class="footer-link small">Terms of Service</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Scroll to Top Button -->
  <button id="scrollTop" class="scrollTop">
    <i class="fas fa-arrow-up"></i>
  </button>

  <script>
    // Scroll to top button
    const scrollTopBtn = document.getElementById('scrollTop');

    window.addEventListener('scroll', () => {
      if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        scrollTopBtn.style.display = 'block';
      } else {
        scrollTopBtn.style.display = 'none';
      }
    });

    scrollTopBtn.addEventListener('click', () => {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  </script>

  @yield('scripts')
</body>

</html>
