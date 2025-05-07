{{-- resources/views/admin/admin-cart.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container py-4">
  <h2>Cart Items</h2>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <table class="table table-striped">
    <thead>
      <tr>
        <th>User ID</th>
        <th>First Name</th>    {{-- now showing only first name --}}
        <th>Business</th>
        <th>Project</th>
        <th>Status</th>
        <th>Added At</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($cartItems as $item)
      <tr>
        <td>{{ $item->user->id }}</td>
        <td>{{ $item->user->first_name }}</td>
        <td>{{ $item->user->company_name ?? '—' }}</td>
        <td>{{ $item->project->project_name }}</td>
        <td>{{ ucfirst($item->status) }}</td>
        <td>{{ $item->created_at->format('Y-m-d H:i') }}</td>
        <td>
          <button
            class="btn btn-sm btn-info"
            data-bs-toggle="modal"
            data-bs-target="#detailModal-{{ $item->id }}"
          >Details</button>
        </td>
      </tr>

      <!-- Detail Modal -->
      <div
        class="modal fade"
        id="detailModal-{{ $item->id }}"
        tabindex="-1"
        aria-labelledby="detailModalLabel-{{ $item->id }}"
        aria-hidden="true"
      >
        <div class="modal-dialog">
          <form
            action="{{ route('admin.cart.update', $item) }}"
            method="POST"
          >
            @csrf
            @method('PATCH')

            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel-{{ $item->id }}">
                  Cart Item #{{ $item->id }} Details
                </h5>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>

              <div class="modal-body">
                <p><strong>User ID:</strong> {{ $item->user->id }}</p>
                <p><strong>First Name:</strong> {{ $item->user->first_name }}</p>
                <p><strong>Business Name:</strong> {{ $item->user->company_name ?? '—' }}</p>
                <p><strong>Purchase Date:</strong> {{ $item->created_at->format('F j, Y, g:i A') }}</p>

                <div class="mb-3">
                  <label for="status-{{ $item->id }}" class="form-label">Status</label>
                  <select
                    name="status"
                    id="status-{{ $item->id }}"
                    class="form-select"
                  >
                    <option value="quotation" {{ $item->status === 'quotation' ? 'selected' : '' }}>
                      Quotation
                    </option>
                    <option value="ongoing" {{ $item->status === 'ongoing' ? 'selected' : '' }}>
                      Ongoing
                    </option>
                    <option value="delivered" {{ $item->status === 'delivered' ? 'selected' : '' }}>
                      Delivered
                    </option>
                  </select>
                </div>
              </div>

              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-secondary"
                  data-bs-dismiss="modal"
                >Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      @empty
      <tr>
        <td colspan="7" class="text-center">No items in cart.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
