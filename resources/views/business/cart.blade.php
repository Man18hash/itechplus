{{-- resources/views/business/cart.blade.php --}}
@extends('layouts.business')

@section('title', 'My Cart')

@section('content')
<div class="container py-5">
  <h2 class="mb-4">My Cart</h2>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if($items->isEmpty())
    <div class="text-center text-muted my-5">
      <i class="fas fa-shopping-cart fa-3x mb-3"></i>
      <p class="lead">Your cart is empty.</p>
      <a href="{{ route('projects.index') }}" class="btn btn-outline-primary">Browse Projects</a>
    </div>
  @else
    <div class="row g-4">
      @foreach($items as $item)
        @php($p = $item->project)
        <div class="col-sm-6 col-lg-4">
          <div class="card h-100 shadow-sm rounded-lg transition-hover">
            @if($p->cover_image)
              <img 
                src="{{ asset('images/covers/'.$p->cover_image) }}" 
                class="card-img-top rounded-top-lg" 
                alt="{{ $p->project_name }}" 
                style="height:180px; object-fit:cover;"
              >
            @endif

            <div class="card-body d-flex flex-column">
              <h5 class="card-title">{{ $p->project_name }}</h5>

              <div class="mb-2">
                <span class="badge bg-info text-dark">{{ $p->project_type }}</span>
                @if($p->category)
                  <span class="badge bg-secondary">{{ $p->category->name }}</span>
                @endif
              </div>

              <p class="card-text flex-grow-1">
                {{ \Illuminate\Support\Str::limit($p->description, 100) }}
              </p>

              <p class="text-muted small mb-3">
                Published {{ $p->date->format('M j, Y') }}
              </p>

              <div class="mt-auto d-flex justify-content-between align-items-center">
                <form 
                  method="POST" 
                  action="{{ route('cart.remove', $item) }}" 
                  onsubmit="return confirm('Remove this project from your cart?')"
                >
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-outline-danger btn-sm">
                    <i class="fas fa-trash-alt me-1"></i> Remove
                  </button>
                </form> 
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>
@endsection

@section('modals')
  <!-- Modal: Edit Profile Info -->
  <div class="modal fade" id="infoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <form method="POST"
            action="{{ route('profile.info') }}"
            class="modal-content">
        @csrf
        @method('PATCH')    {{-- ← required to hit your PATCH route --}}

        <div class="modal-header">
          <h5 class="modal-title">Edit Profile Info</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            @foreach([
              'first_name'=>'First Name','last_name'=>'Last Name',
              'company_name'=>'Company','company_size'=>'Company Size',
              'position'=>'Position','mobile'=>'Mobile',
              'street'=>'Street','barangay'=>'Barangay',
              'city'=>'City','region'=>'Region'
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


@push('styles')
<style>
  /* subtle lift effect on hover */
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
