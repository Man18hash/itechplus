{{-- resources/views/business/projects.blade.php --}}
@extends('layouts.business')

@section('title', 'Projects')

@section('content')
<div class="container py-5">
  <!-- Search form -->
  <form method="GET" action="{{ route('home') }}" class="mb-4">
    <div class="input-group">
      <input
        type="text"
        name="search"
        class="form-control"
        placeholder="Search projects..."
        value="{{ old('search', $search) }}"
      >
      <button class="btn btn-primary" type="submit">
        <i class="fas fa-search"></i> Search
      </button>
    </div>
  </form>

  <!-- Filter by Type & Category -->
  <div class="mb-4">
    <form action="{{ route('home') }}" method="GET" class="row g-3 align-items-end">
      <div class="col-md-4">
        <label for="type" class="form-label">Filter by Type</label>
        <select name="type" id="type" class="form-select">
          <option value="">All Types</option>
          @foreach ($types as $typeOption)
            <option value="{{ $typeOption }}"
              {{ $type == $typeOption ? 'selected' : '' }}>
              {{ $typeOption }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-4">
        <label for="category" class="form-label">Filter by Category</label>
        <select name="category" id="category" class="form-select">
          <option value="">All Categories</option>
          @foreach ($categories as $id => $name)
            <option value="{{ $id }}"
              {{ $category == $id ? 'selected' : '' }}>
              {{ $name }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-4">
        <button type="submit" class="btn btn-primary w-100">Filter</button>
      </div>

      @if($type || $category)
        <div class="col-12">
          <a href="{{ route('home') }}"
             class="btn btn-sm btn-outline-secondary">
            Clear Filters
          </a>
        </div>
      @endif
    </form>
  </div>

  <!-- Projects Grid -->
  <div class="row g-4">
    @forelse($projects as $project)
      <div class="col-md-4">
        <div class="card h-100 text-center shadow-sm transition-hover rounded-lg">
          @if($project->cover_image)
            <img
              src="{{ asset('images/covers/'.$project->cover_image) }}"
              class="card-img-top rounded-top-lg mx-auto mt-3"
              alt="{{ $project->project_name }}"
              style="width:100px; height:100px; object-fit:cover;"
            >
          @endif

          <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ $project->project_name }}</h5>
            <p class="card-text flex-grow-1 text-muted">
              {{ \Illuminate\Support\Str::limit($project->description, 100) }}
            </p>
            <p class="mb-1"><strong>Type:</strong> {{ $project->project_type }}</p>
            @if($project->category)
              <p class="mb-1"><strong>Category:</strong> {{ $project->category->name }}</p>
            @endif
          </div>

          <div class="card-footer d-flex justify-content-between align-items-center">
            <small class="text-muted">{{ $project->date->format('M j, Y') }}</small>
            <form method="POST"
                  action="{{ route('cart.add', $project) }}"
                  class="quotation-form">
              @csrf
              <button type="button"
                      class="btn btn-primary btn-sm quotation-btn">
                Get Quotation
              </button>
            </form>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12 text-center text-muted">
        No projects found.
      </div>
    @endforelse
  </div>

  {{-- Pagination --}}
  @if(method_exists($projects, 'links'))
    <div class="mt-4">
      {{ $projects->links() }}
    </div>
  @endif
</div>
@endsection

@section('modals')
  {{-- Quotation Confirm Modal --}}
  <div class="modal fade" id="quotationConfirmModal" tabindex="-1" aria-labelledby="quotationConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="quotationConfirmModalLabel">Confirm Quotation</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to add this project to your quotation list?
        </div>
        <div class="modal-footer">
          <button type="button"
                  class="btn btn-secondary"
                  data-bs-dismiss="modal">Cancel</button>
          <button type="button"
                  class="btn btn-primary"
                  id="confirmQuotationBtn">Yes, Add</button>
        </div>
      </div>
    </div>
  </div>

  {{-- Edit Profile Info Modal --}}
  <div class="modal fade" id="infoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <form method="POST"
            action="{{ route('profile.info') }}"
            class="modal-content">
        @csrf
        @method('PATCH')

        <div class="modal-header">
          <h5 class="modal-title">Edit Profile Info</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            @foreach([
              'first_name'   => 'First Name',
              'last_name'    => 'Last Name',
              'company_name' => 'Company',
              'company_size' => 'Company Size',
              'position'     => 'Position',
              'mobile'       => 'Mobile',
              'street'       => 'Street',
              'barangay'     => 'Barangay',
              'city'         => 'City',
              'region'       => 'Region',
            ] as $field => $label)
              <div class="col-md-6">
                <label class="form-label">{{ $label }}</label>
                <input type="text"
                       name="{{ $field }}"
                       value="{{ old($field, auth()->user()->{$field}) }}"
                       class="form-control @error($field) is-invalid @enderror">
                @error($field)
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            @endforeach
          </div>
        </div>

        <div class="modal-footer">
          <button type="button"
                  class="btn btn-secondary"
                  data-bs-dismiss="modal">Cancel</button>
          <button type="submit"
                  class="btn btn-success">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Quotation modal setup
    const qEl = document.getElementById('quotationConfirmModal');
    if (qEl) {
      const qModal = new bootstrap.Modal(qEl);
      let formToSubmit = null;
      document.querySelectorAll('.quotation-btn').forEach(btn => {
        btn.addEventListener('click', e => {
          formToSubmit = e.target.closest('.quotation-form');
          qModal.show();
        });
      });
      document.getElementById('confirmQuotationBtn')
              .addEventListener('click', () => formToSubmit?.submit());
    }
  });
</script>
@endpush

@push('styles')
<style>
  .transition-hover {
    transition: transform .2s, box-shadow .2s;
  }
  .transition-hover:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.1);
  }
  .rounded-lg {
    border-radius: .75rem;
  }
  .rounded-top-lg {
    border-top-left-radius: .75rem;
    border-top-right-radius: .75rem;
  }
</style>
@endpush
