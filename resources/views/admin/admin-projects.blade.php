{{-- resources/views/admin/admin-projects.blade.php --}}

@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Projects</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProjectModal">
      + Add Project
    </button>
  </div>

  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Type</th>
        <th>Name</th>
        <th>Date</th>
        <th>Category</th>
        <th>Cover</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($projects as $project)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $project->project_type }}</td>
        <td>{{ $project->project_name }}</td>
        <td>{{ $project->date->format('Y-m-d') }}</td>
        <td>{{ $project->category->name }}</td>
        <td>
          @if($project->cover_image)
            <img 
              src="{{ asset('images/covers/'.$project->cover_image) }}" 
              alt="{{ $project->project_name }}" 
              width="50" height="50" 
              style="object-fit: cover;"
            >
          @endif
        </td>
        <td>
          <button
            class="btn btn-sm btn-warning edit-btn"
            data-id="{{ $project->id }}"
            data-project_type="{{ $project->project_type }}"
            data-project_name="{{ $project->project_name }}"
            data-description="{{ $project->description }}"
            data-date="{{ $project->date->format('Y-m-d') }}"
            data-category_id="{{ $project->category_id }}"
            data-bs-toggle="modal"
            data-bs-target="#editProjectModal"
          >Edit</button>

          <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this project?')">
              Delete
            </button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<!-- Create Project Modal -->
<div class="modal fade" id="createProjectModal" tabindex="-1" aria-labelledby="createProjectLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createProjectLabel">Add New Project</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <!-- same fields as before -->
          <div class="mb-3">
            <label for="project_type" class="form-label">Project Type</label>
            <input type="text" name="project_type" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="project_name" class="form-label">Name</label>
            <input type="text" name="project_name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" rows="3" class="form-control"></textarea>
          </div>
          <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" class="form-select" required>
              <option value="" disabled selected>Choose…</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="cover_image" class="form-label">Cover Image</label>
            <input type="file" name="cover_image" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Create Project</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Edit Project Modal -->
<div class="modal fade" id="editProjectModal" tabindex="-1" aria-labelledby="editProjectLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editProjectForm" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editProjectLabel">Edit Project</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit-id">
          <div class="mb-3">
            <label class="form-label">Project Type</label>
            <input type="text" name="project_type" id="edit-project_type" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="project_name" id="edit-project_name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" id="edit-description" rows="3" class="form-control"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" id="edit-date" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" id="edit-category_id" class="form-select" required>
              <option value="" disabled>Choose…</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Cover Image</label>
            <input type="file" name="cover_image" class="form-control">
            <small class="text-muted">Leave empty to keep current image</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-warning">Save Changes</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
  document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const id   = btn.dataset.id;
      const form = document.getElementById('editProjectForm');
      form.action = `/admin/projects/${id}`;

      document.getElementById('edit-id').value           = id;
      document.getElementById('edit-project_type').value = btn.dataset.project_type;
      document.getElementById('edit-project_name').value = btn.dataset.project_name;
      document.getElementById('edit-description').value  = btn.dataset.description;
      document.getElementById('edit-date').value         = btn.dataset.date;
      document.getElementById('edit-category_id').value  = btn.dataset.category_id;
    });
  });
</script>
@endpush
