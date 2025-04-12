@extends('layouts.admin')

@section('title', 'Add New Category')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
  <li class="breadcrumb-item active">Add New</li>
@endsection

@section('content')
  <div class="card">
    <div class="card-header">
      <h5 class="mb-0">Add New Category</h5>
    </div>
    <div class="card-body">
      <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <div class="mb-3">
          <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
            value="{{ old('name') }}" required>
          @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="slug" class="form-label">Slug</label>
          <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"
            value="{{ old('slug') }}">
          <div class="form-text">Leave empty to automatically generate from name.</div>
          @error('slug')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="d-flex justify-content-end">
          <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary me-2">Cancel</a>
          <button type="submit" class="btn btn-primary">Save Category</button>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const nameInput = document.getElementById('name');
      const slugInput = document.getElementById('slug');

      nameInput.addEventListener('blur', function() {
        if (slugInput.value === '') {
          // Create slug from name
          const name = nameInput.value;
          const slug = name
            .toLowerCase()
            .replace(/[^\w ]+/g, '')
            .replace(/ +/g, '-');

          slugInput.value = slug;
        }
      });
    });
  </script>
@endsection
