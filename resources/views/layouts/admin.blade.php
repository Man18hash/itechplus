<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>@yield('title') — Admin Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
      <!-- Brand / Logo -->
      <a class="navbar-brand" href="{{ route('admin.home') }}">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" height="75"
             onerror="this.onerror=null;this.src='https://via.placeholder.com/30';">
      </a>

      <!-- Toggle button for small screens -->
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#adminNav"
        aria-controls="adminNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div id="adminNav" class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.home') }}">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.messages') }}">Messages</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.projects') }}">Projects</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.cart') }}">Cart</a>
          </li>
          <li class="nav-item">
            <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
              @csrf
              <button type="submit" class="nav-link btn btn-link text-danger">
                Logout
              </button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  {{-- Page Content --}}
  <main class="py-4">
    <div class="container">
      @yield('content')
    </div>
  </main>

  {{-- Page-specific Modals --}}
  @yield('modals')

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  {{-- Additional Scripts --}}
  @stack('scripts')
</body>
</html>
