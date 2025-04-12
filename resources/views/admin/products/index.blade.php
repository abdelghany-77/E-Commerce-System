@extends('layouts.admin')

@section('title', 'Products')

@section('breadcrumb')
  <li class="breadcrumb-item active">Products</li>
@endsection

@section('content')
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">All Products</h5>
      <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Product
      </a>
    </div>
    <div class="card-body">
      @if ($products->isEmpty())
        <p class="text-center">No products found.</p>
      @else
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Created</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($products as $product)
                <tr>
                  <td>{{ $product->id }}</td>
                  <td>
                    @if ($product->image)
                      <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="50"
                        height="50" style="object-fit: cover;">
                    @else
                      <div class="bg-light text-center" style="width: 50px; height: 50px;">
                        <i class="fas fa-image text-muted" style="line-height: 50px;"></i>
                      </div>
                    @endif
                  </td>
                  <td>{{ $product->name }}</td>
                  <td>${{ number_format($product->price, 2) }}</td>
                  <td>{{ $product->stock }}</td>
                  <td>
                    @if ($product->is_active)
                      <span class="badge bg-success">Active</span>
                    @else
                      <span class="badge bg-danger">Inactive</span>
                    @endif
                  </td>
                  <td>{{ $product->created_at->format('M d, Y') }}</td>
                  <td>
                    <div class="btn-group">
                      <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i>
                      </a>
                      <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this product?');">
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
          {{ $products->onEachSide(1)->links('pagination.bootstrap-5') }}
        </div>
      @endif
    </div>
  </div>
@endsection
