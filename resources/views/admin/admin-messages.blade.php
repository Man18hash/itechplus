{{-- resources/views/admin/admin-message.blade..php--}}

@extends('layouts.admin')

@section('content')
<div class="container py-4">
  <h2>All Message Threads</h2>

  @if($threads->isEmpty())
    <p>No threads available.</p>
  @else
    <ul class="list-group">
      @foreach($threads as $thread)
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <div>
            <strong>{{ $thread->project->project_name }}</strong><br>
            by {{ $thread->user->first_name }} (ID: {{ $thread->user->id }})
          </div>
          <a href="{{ route('admin.messages.chat', $thread) }}" class="btn btn-sm btn-info">
            View Chat
          </a>
        </li>
      @endforeach
    </ul>
  @endif
</div>
@endsection
