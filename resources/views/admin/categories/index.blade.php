@extends('layouts.admin')

@section('title', 'Categories')

@section('breadcrumb')
  <li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">All Categories</h5>
      <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Category
      </a>
    </div>
    <div class="card-body">
      @if ($categories->isEmpty())
        <p class="text-center">No categories found.</p>
      @else
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Products</th>
                <th>Created</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($categories as $category)
                <tr>
                  <td>{{ $category->id }}</td>
                  <td>{{ $category->name }}</td>
                  <td>{{ $category->slug }}</td>
                  <td>{{ $category->products->count() }}</td>
                  <td>{{ $category->created_at->format('M d, Y') }}</td>
                  <td>
                    <div class="btn-group">
                      <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i>
                      </a>
                      <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this category?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                          <i class="fas fa-trash"></i>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
       <div class="card-footer bg-transparent">
          {{ $categories->onEachSide(1)->links('pagination.bootstrap-5') }}
        </div>
      @endif
    </div>
  </div>
@endsection
