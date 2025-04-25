@extends('layouts.admin')

@section('title', 'Add New Product')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
  <li class="breadcrumb-item active">Add New</li>
@endsection

@section('content')
  <div class="card">
    <div class="card-header">
      <h5 class="mb-0">Add New Product</h5>
    </div>
    <div class="card-body">
      <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row mb-3">
          <div class="col-md-6">
            <div class="mb-3">
              <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                value="{{ old('name') }}" required>
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text">$</span>
                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                  name="price" value="{{ old('price') }}" step="0.01" min="0" required>
                @error('price')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
          {{-- for discount price --}}
          <div class="col-md-6">
            <div class="mb-3">
              <label for="discount_price" class="form-label">Discount Price</label>
              <div class="input-group">
                <span class="input-group-text">$</span>
                <input type="number" class="form-control @error('discount_price') is-invalid @enderror"
                  id="discount_price" name="discount_price" value="{{ old('discount_price') }}" step="0.01"
                  min="0">
                @error('discount_price')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <div class="mb-3">
              <label for="stock" class="form-label">Stock <span class="text-danger">*</span></label>
              <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock"
                name="stock" value="{{ old('stock', 0) }}" min="0" required>
              @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label for="image" class="form-label">Product Image</label>
              <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                name="image">
              @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
          <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
            rows="5" required>{{ old('description') }}</textarea>
          @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Categories</label>
          <div class="row">
            @foreach ($categories as $category)
              <div class="col-md-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}"
                    id="category-{{ $category->id }}"
                    {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                  <label class="form-check-label" for="category-{{ $category->id }}">
                    {{ $category->name }}
                  </label>
                </div>
              </div>
            @endforeach
          </div>
          @error('categories')
            <div class="text-danger mt-1">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
              {{ old('is_active') ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">
              Active
            </label>
          </div>
        </div>

        <div class="d-flex justify-content-end">
          <a href="{{ route('admin.products.index') }}" class="btn btn-secondary me-2">Cancel</a>
          <button type="submit" class="btn btn-primary">Save Product</button>
        </div>
      </form>
    </div>
  </div>
@endsection
