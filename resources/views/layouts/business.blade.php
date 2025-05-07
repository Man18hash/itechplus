<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'iTechConnect')</title>

  <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >

  <!-- Your custom CSS -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="{{ route('dashboard') }}">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" height="75"
             onerror="this.onerror=null;this.src='https://via.placeholder.com/30';">
      </a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#nav"
        aria-controls="nav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div id="nav" class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          @auth
            <li class="nav-item">
              <a class="nav-link" href="{{ route('home') }}">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('cart.index') }}">Cart</a>
            </li>
            <!-- New Messages tab -->
            <li class="nav-item">
              <a class="nav-link" href="{{ route('messages') }}">Messages</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle d-flex align-items-center"
                 href="#"
                 id="profileMenu"
                 role="button"
                 data-bs-toggle="dropdown"
                 aria-expanded="false"
              >
                {{ auth()->user()->first_name }}
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileMenu">
                <li>
                  <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#infoModal">
                    Edit Profile Info
                  </button>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form method="POST" action="{{ route('auth.logout') }}">
                    @csrf
                    <button class="dropdown-item text-danger">Logout</button>
                  </form>
                </li>
              </ul>
            </li>
          @else
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">Login</a>
            </li>
          @endauth
        </ul>
      </div>
    </div>
  </nav>

  {{-- page-specific content --}}
  @yield('content')

  {{-- page-specific modals --}}
  @yield('modals')

  <!-- Bootstrap JS bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  {{-- This renders any <script> blocks you pushed in child views --}}
  @stack('scripts')
</body>
</html>
