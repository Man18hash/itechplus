{{-- resources/views/auth/register.blade.php --}}

<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Sign Up</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>

      <form method="POST" action="{{ route('auth.register') }}">
        @csrf
        <div class="modal-body">
          @if($errors->any())
            <div class="alert alert-danger">
              Please fix the errors below.
            </div>
          @endif

          <div class="row">
            {{-- First & Last Name --}}
            <div class="col-md-6 mb-3">
              <label class="form-label">First Name</label>
              <input
                type="text"
                name="first_name"
                class="form-control @error('first_name') is-invalid @enderror"
                value="{{ old('first_name') }}"
                required
              >
              @error('first_name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Last Name</label>
              <input
                type="text"
                name="last_name"
                class="form-control @error('last_name') is-invalid @enderror"
                value="{{ old('last_name') }}"
                required
              >
              @error('last_name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- Company & Size --}}
            <div class="col-md-6 mb-3">
              <label class="form-label">Company / Organization</label>
              <input
                type="text"
                name="company_name"
                class="form-control @error('company_name') is-invalid @enderror"
                value="{{ old('company_name') }}"
              >
              @error('company_name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
  <label class="form-label">Company Size</label>
  <select
    name="company_size"
    class="form-control @error('company_size') is-invalid @enderror"
  >
    <option value="">-- Select size --</option>
    <option value="small"  {{ old('company_size') == 'small'  ? 'selected' : '' }}>Small</option>
    <option value="medium" {{ old('company_size') == 'medium' ? 'selected' : '' }}>Medium</option>
    <option value="large"  {{ old('company_size') == 'large'  ? 'selected' : '' }}>Large</option>
  </select>
  @error('company_size')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>


            {{-- Position & Mobile --}}
            <div class="col-md-6 mb-3">
              <label class="form-label">Designation / Position</label>
              <input
                type="text"
                name="position"
                class="form-control @error('position') is-invalid @enderror"
                value="{{ old('position') }}"
              >
              @error('position')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Mobile #</label>
              <input
                type="text"
                name="mobile"
                class="form-control @error('mobile') is-invalid @enderror"
                value="{{ old('mobile') }}"
              >
              @error('mobile')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- Location Fields --}}
            <div class="col-12 mb-2"><h6>Location</h6></div>
            @foreach(['street','barangay','Municipality','region'] as $field)
              <div class="col-md-6 mb-3">
                <label class="form-label">{{ ucfirst($field) }}</label>
                <input
                  type="text"
                  name="{{ $field }}"
                  class="form-control @error($field) is-invalid @enderror"
                  value="{{ old($field) }}"
                >
                @error($field)
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            @endforeach

            {{-- Email & Password --}}
            <div class="col-md-6 mb-3">
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
            <div class="col-md-6 mb-3">
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
            <div class="col-md-6 mb-3">
              <label class="form-label">Confirm Password</label>
              <input
                type="password"
                name="password_confirmation"
                class="form-control @error('password_confirmation') is-invalid @enderror"
                required
              >
              @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
          >
            Cancel
          </button>
          <button type="submit" class="btn btn-success">Register</button>
        </div>
      </form>
    </div>
  </div>
</div>
