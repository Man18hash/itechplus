{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.guest')

@section('title', 'Projects Dashboard')

@section('content')
<div class="container py-5">
  <!-- Page Header -->
  <div class="text-center mb-5">
    <h1 class="display-4">Browse Our Available Projects</h1>
    <p class="lead text-muted">Search by keyword or category</p>
  </div>

  <!-- Search + Category Filter -->
  <form method="GET" action="{{ route('dashboard') }}" class="row g-3 mb-5 align-items-end">
    <div class="col-md-6">
      <label class="form-label">Search</label>
      <input
        type="text"
        name="search"
        class="form-control"
        placeholder="Search projects..."
        value="{{ old('search', $search) }}"
      >
    </div>
    <div class="col-md-4">
      <label class="form-label">Category</label>
      <select name="category" class="form-select">
        <option value="">All Categories</option>
        @foreach($categories as $id => $name)
          <option value="{{ $id }}" {{ $category == $id ? 'selected' : '' }}>{{ $name }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-2">
      <button type="submit" class="btn btn-primary w-100">Filter</button>
    </div>
    @if($search || $category)
      <div class="col-12">
        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary">Clear Filters</a>
      </div>
    @endif
  </form>

  <!-- Custom Styles -->
  <style>
    .project-card {
      transition: transform .3s ease, box-shadow .3s ease;
      cursor: default;
    }
    .project-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    .project-card img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: .5rem;
    }
    .project-card .card-title {
      font-size: 1rem;
      margin-top: .5rem;
    }
    .project-card .card-text {
      font-size: .85rem;
      margin-top: .25rem;
    }
    .project-footer {
      background: transparent;
      border-top: 1px solid #e9ecef;
      padding: .75rem 1rem;
    }
  </style>

  <!-- Projects Grid -->
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
    @forelse($projects as $project)
      <div class="col">
        <div class="card h-100 shadow-sm project-card d-flex flex-column">
          <div class="card-body text-center flex-grow-1">
            @if($project->cover_image)
              <img
                src="{{ asset('images/covers/'.$project->cover_image) }}"
                alt="{{ $project->project_name }}"
              >
            @endif
            <h5 class="card-title">{{ $project->project_name }}</h5>
            <p class="card-text text-muted">
              {{ \Illuminate\Support\Str::limit($project->description, 80) }}
            </p>
          </div>
          <div class="project-footer d-flex justify-content-between align-items-center">
            <small class="text-muted">{{ $project->date->format('M j, Y') }}</small>
            <button
              type="button"
              class="btn btn-outline-primary btn-sm"
              data-bs-toggle="modal"
              data-bs-target="#quoteModal"
            >Get Quotation</button>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12 text-center text-muted">No projects found.</div>
    @endforelse
  </div>
</div>

<!-- Quotation Modal -->
<div class="modal fade" id="quoteModal" tabindex="-1" aria-labelledby="quoteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="quoteModalLabel">Get Quotation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <p>You must sign up or log in to get a quotation.</p>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <a href="{{ route('login') }}" class="btn btn-primary">Yes, Log In</a>
      </div>
    </div>
  </div>
</div>
@endsection
