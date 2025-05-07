@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-5">
  <h3 class="mb-4">All Projects</h3>

  <div class="row g-4">
    @forelse($projects as $project)
      <div class="col-md-4">
        <div class="card h-100 text-center">
          @if($project->cover_image)
            <img
              src="{{ asset('images/covers/'.$project->cover_image) }}"
              class="card-img-top mx-auto mt-3"
              alt="{{ $project->project_name }}"
              style="width:100px; height:100px; object-fit:cover;"
            >
          @endif

          <div class="card-body">
            <h5 class="card-title">{{ $project->project_name }}</h5>
            <p class="card-text">
              {{ \Illuminate\Support\Str::limit($project->description, 100) }}
            </p>
            <p class="mb-0"><strong>Type:</strong> {{ $project->project_type }}</p>
            @if($project->category)
              <p class="mb-0"><strong>Category:</strong> {{ $project->category->name }}</p>
            @endif
          </div>

          <div class="card-footer text-muted">
            {{ $project->created_at->format('M j, Y') }}
          </div>
        </div>
      </div>
    @empty
      <div class="col-12 text-center">
        No projects available.
      </div>
    @endforelse
  </div>
</div>
@endsection
