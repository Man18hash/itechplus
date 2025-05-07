{{-- resources/views/partials/navbar.blade.php --}}
<header class="navbar">
  <div class="nav-wrapper">
    {{-- Logo on the left --}}
    <a href="{{ route('researches.index') }}" class="logo">
      <img src="{{ asset('images/your-logo.png') }}" alt="Site Logo">
    </a>

    {{-- Nav links on the right --}}
    <nav class="nav-menu">
      <ul>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('researches.index') }}">Projects</a></li>
      </ul>
    </nav>
  </div>
</header>
