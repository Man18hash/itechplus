<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {{-- CSRF token for AJAX --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'iTechConnect')</title>

  <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
  <!-- Your custom CSS -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">

  <!-- Bootstrap JS bundle -->
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    defer
  ></script>
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="{{ route('dashboard') }}">
        <img
          src="{{ asset('images/logo.png') }}"
          alt="Site Logo"
          height="30"
          onerror="this.onerror=null;this.src='https://via.placeholder.com/30';"
        >
      </a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#mainNav"
        aria-controls="mainNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a
              class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
              href="{{ route('dashboard') }}"
            >Home</a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link {{ request()->routeIs('researches.index') ? 'active' : '' }}"
              href="{{ route('researches.index') }}"
            >Researches</a>
          </li>
          @guest
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">Login</a>
            </li>
          @else
            <li class="nav-item">
              <form method="POST" action="{{ route('auth.logout') }}">
                @csrf
                <button type="submit" class="btn btn-link nav-link">Logout</button>
              </form>
            </li>
          @endguest
        </ul>
      </div>
    </div>
  </nav>

  <main class="py-4">
    @yield('content')
  </main>

  {{-- This will pull in any scripts pushed by child views --}}
  @stack('scripts')
</body>
</html>
