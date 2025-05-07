@extends('layouts.app')

@section('title', 'Login / Register')

@section('content')
<div class="container py-5">
  {{-- Flash errors --}}
  @if(session('error'))
    <div class="alert alert-warning">
      {{ session('error') }}
    </div>
  @endif

  {{-- Login Form --}}
  <div class="row justify-content-center mb-4">
    <div class="col-md-6">
      <h2 class="mb-3">Sign In</h2>
      <form method="POST" action="{{ route('auth.login') }}">
        @csrf
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input
            type="email"
            name="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email') }}"
            required
          >
          @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Password</label>
          <input
            type="password"
            name="password"
            class="form-control @error('password') is-invalid @enderror"
            required
          >
          @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-check mb-3">
          <input
            type="checkbox"
            name="remember"
            id="remember"
            class="form-check-input"
          >
          <label for="remember" class="form-check-label">Remember Me</label>
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
      </form>
    </div>
  </div>

  {{-- Register Button --}}
  <div class="text-center">
    <button
      class="btn btn-success"
      data-bs-toggle="modal"
      data-bs-target="#registerModal"
    >
      Create an Account
    </button>
  </div>
</div>

{{-- Include the register modal --}}
@include('auth.register')
@endsection
