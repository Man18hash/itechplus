{{-- resources/views/researches.blade.php --}}
@extends('layouts.guest')

@section('title', 'DOST Technology & Services')

@section('content')
<div class="container py-5">
  <!-- Page Header -->
  <div class="text-center mb-5">
    <h1 class="display-4">Be Part of ITechPlus</h1>
    <p class="lead text-muted">Select a Technology Category &amp; Apply</p>
  </div>

  <!-- Custom Styles -->
  <style>
    .category-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: default;
    }
    .category-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
    .category-card img {
      width: 60px;
      height: 60px;
      object-fit: contain;
    }
    .category-card .card-title {
      font-size: 0.9rem;
    }
  </style>

  <!-- Categories Grid -->
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
    @foreach($categories as $category)
      <div class="col">
        <div class="card h-100 text-center shadow-sm category-card">
          <div class="card-body d-flex flex-column align-items-center py-4">
            <img
              src="{{ asset('images/categories/'.$category->image) }}"
              alt="{{ $category->name }} Icon"
              onerror="this.onerror=null;this.src='https://via.placeholder.com/60';"
            >
            <h5 class="card-title mt-3">{{ $category->name }}</h5>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <!-- Download & Contact -->
  <div class="mt-5 text-center">
    <a
      href="{{ asset('docs/dost_application_template.docx') }}"
      class="btn btn-primary btn-lg me-3"
      download
    >
      Download Application Form
    </a>
    <a href="mailto:itechconnectr02@gmail.com" class="btn btn-outline-secondary btn-lg">
      Email Us
    </a>
    <!-- Email Address Display -->
    <p class="mt-3 text-muted">
      You can also reach us directly at:
      <a href="mailto:itechconnectr02@gmail.com">itechplusr02@gmail.com</a>
    </p>
  </div>
</div>
@endsection
