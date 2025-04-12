<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - @yield('title')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    {{-- custom Css --}}
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @yield('styles')
</head>

<body>
  <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

  <div id="sidebar">
    <div class="sidebar-header">
      <h3 class="mb-0 fs-5">E-Shop Admin</h3>
      <small class="text-muted">Management Panel</small>
    </div>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}"
          href="{{ route('admin.dashboard') }}">
          <i class="fas fa-tachometer-alt me-2"></i> Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}"
          href="{{ route('admin.products.index') }}">
          <i class="fas fa-box me-2"></i> Products
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
          href="{{ route('admin.orders.index') }}">
          <i class="fas fa-shopping-cart me-2"></i> Orders
          @if (isset($newOrdersCount) && $newOrdersCount > 0)
            <span class="badge bg-danger rounded-pill position-absolute"
              style="font-size: 0.65em; transform: translate(0.5em, -0.5em);">
              {{ $newOrdersCount }} new
            </span>
          @endif
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}"
          href="{{ route('admin.categories.index') }}">
          <i class="fas fa-tags me-2"></i> Categories
        </a>
    </ul>
  </div>

  <div id="content">
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="container-fluid px-0">
        <button class="btn btn-link text-dark" id="sidebarToggle">
          <i class="fas fa-bars"></i>
        </button>

        <div class="d-flex align-items-center ms-auto">
          <div class="dropdown">
            <a class="btn btn-link text-dark text-decoration-none" href="#" role="button" id="userDropdown"
              data-bs-toggle="dropdown">
              <i class="fas fa-user-circle me-2"></i>
              <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end mt-2">
              <li>
                <a class="dropdown-item" href="{{ route('home') }}" target="_blank">
                  <i class="fas fa-home me-2"></i> View site
                </a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <form action="{{ route('logout') }}" method="POST">
                  @csrf
                  <button type="submit" class="dropdown-item">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                  </button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>

    <main class="container-fluid p-3 p-lg-4">
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

      <div class="content-header mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
          <h1 class="m-0 fs-3">@yield('title')</h1>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 mt-2 mt-md-0">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
              @yield('breadcrumb')
            </ol>
          </nav>
        </div>
      </div>

      @yield('content')
    </main>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const sidebar = document.getElementById('sidebar');
      const sidebarToggle = document.getElementById('sidebarToggle');
      const sidebarBackdrop = document.getElementById('sidebarBackdrop');

      function toggleSidebar() {
        sidebar.classList.toggle('active');
        sidebarBackdrop.classList.toggle('active');
      }

      sidebarToggle.addEventListener('click', toggleSidebar);
      sidebarBackdrop.addEventListener('click', toggleSidebar);

      // Close sidebar when clicking outside on mobile
      document.addEventListener('click', (e) => {
        if (window.innerWidth < 768 &&
          !sidebar.contains(e.target) &&
          !sidebarToggle.contains(e.target)) {
          sidebar.classList.remove('active');
          sidebarBackdrop.classList.remove('active');
        }
      });

      document.querySelectorAll('#sidebar a').forEach(link => {
        link.addEventListener('click', () => {
          if (window.innerWidth < 768) {
            toggleSidebar();
          }
        });
      });
    });
  </script>
  @yield('scripts')
</body>

</html>
