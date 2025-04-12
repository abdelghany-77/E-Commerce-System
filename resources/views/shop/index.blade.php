@extends('layouts.app')

@section('title', 'Shop')

@section('content')
  <div class="row">
    <div class="col-md-3 mb-4">
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">Categories</h5>
        </div>
        <div class="card-body">
          <div class="list-group">
            <a href="{{ route('shop.index') }}"
              class="list-group-item list-group-item-action {{ !request('category') ? 'active' : '' }}">
              All Products
            </a>
            @foreach ($categories as $category)
              <a href="{{ route('shop.index', ['category' => $category->slug]) }}"
                class="list-group-item list-group-item-action {{ request('category') == $category->slug ? 'active' : '' }}">
                {{ $category->name }}
              </a>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-9">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Products</h2>
        <div class="dropdown">
          <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown"
            data-bs-toggle="dropdown">
            Sort By:
            @if(request('sort') == 'price_asc')
              Price: Low to High
            @elseif(request('sort') == 'price_desc')
              Price: High to Low
            @elseif(request('sort') == 'newest')
              Newest First
            @else
              Default
            @endif
          </button>
          <ul class="dropdown-menu" aria-labelledby="sortDropdown">
            <li><a class="dropdown-item {{ request('sort') == 'price_asc' ? 'active' : '' }}"
                href="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}">Price: Low to High</a></li>
            <li><a class="dropdown-item {{ request('sort') == 'price_desc' ? 'active' : '' }}"
                href="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}">Price: High to Low</a></li>
            <li><a class="dropdown-item {{ request('sort') == 'newest' ? 'active' : '' }}"
                href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">Newest First</a></li>
          </ul>
        </div>
      </div>

      @if ($products->isEmpty())
        <div class="alert alert-info">
          No products found.
        </div>
      @else
        <div class="row">
          @foreach ($products as $product)
            <div class="col-md-4 mb-4">
              <div class="card product-card h-100">
                @if ($product->image)
                  <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top product-img"
                    alt="{{ $product->name }}">
                @else
                  <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top product-img"
                    alt="No Image">
                @endif
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title">{{ $product->name }}</h5>
                  <p class="card-text text-truncate">{{ $product->description }}</p>
                  <div class="mt-auto">
                    <p class="fw-bold">${{ number_format($product->price, 2) }}</p>
                    <a href="{{ route('shop.show', $product) }}" class="btn btn-primary btn-sm">View Details</a>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <div class="card-footer bg-transparent">
          {{ $products->onEachSide(1)->links('pagination.bootstrap-5') }}
        </div>
      @endif
    </div>
  </div>
@endsection
