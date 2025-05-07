<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="{{ route('dashboard') }}">iTechConnect</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto">
        @auth
          <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('cart.index') }}">Cart</a>
          </li>
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle d-flex align-items-center"
              href="#"
              id="profileMenu"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <img
                src="{{ auth()->user()->profile_image 
                  ? asset('storage/' . auth()->user()->profile_image)
                  : asset('images/default-avatar.png') }}"
                alt="Profile"
                class="rounded-circle me-2"
                width="30" height="30"
                style="object-fit:cover;"
              >
              {{ auth()->user()->first_name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileMenu">
              <li>
                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#imageModal">
                  Edit Profile Image
                </button>
              </li>
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
