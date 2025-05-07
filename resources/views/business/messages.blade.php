@extends('layouts.business')

@section('content')
<div class="container py-4">
  <h2>Your Message Threads</h2>

  @if($threads->isEmpty())
    <p>No active threads.</p>
  @else
    <ul class="list-group">
      @foreach($threads as $thread)
        <li class="list-group-item d-flex justify-content-between align-items-center">
          {{ $thread->project->project_name }}
          <a href="{{ route('messages.chat', $thread) }}" class="btn btn-sm btn-primary">
            Open Chat
          </a>
        </li>
      @endforeach
    </ul>
  @endif
</div>
@endsection

@section('modals')
  <!-- Modal: Edit Profile Image -->
  <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form method="POST"
            action="{{ route('profile.update') }}"
            enctype="multipart/form-data"
            class="modal-content">
        @csrf
        @method('PATCH')    {{-- ← required to hit your PATCH route --}}

        <div class="modal-header">
          <h5 class="modal-title">Edit Profile Image</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Choose Image</label>
            <input type="file"
                   name="profile_image"
                   class="form-control @error('profile_image') is-invalid @enderror"
                   required>
            @error('profile_image')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="modal-footer">
          <button type="button"
                  class="btn btn-secondary"
                  data-bs-dismiss="modal">Cancel</button>
          <button type="submit"
                  class="btn btn-primary">Upload</button>
        </div>
      </form>
    </div>
  </div>

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
