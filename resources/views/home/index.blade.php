@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container-fluid px-0">
  <!-- Hero Section -->
  <div class="hero-section bg-gradient-primary text-white py-5">
    <div class="container text-center">
      <h1 class="display-4 fw-bold mb-4">Welcome to E-Shop</h1>
      <p class="lead mb-4">Discover amazing products at great prices. Shop now and enjoy fast shipping and excellent customer service!</p>
      <a class="btn btn-light btn-lg px-5 rounded-pill" href="{{ route('shop.index') }}">
        Start Shopping <i class="fas fa-arrow-right ms-2"></i>
      </a>
    </div>
  </div>

  <!-- Products by Categories -->
  <div class="container py-5">
    @foreach($categories as $category)
      @if($category->products->isNotEmpty())
        <div class="category-section mb-5">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title mb-0">{{ $category->name }}</h2>
            <a href="{{ route('shop.index', ['category' => $category->slug]) }}"
               class="btn btn-primary btn-lg d-none d-md-inline-flex align-items-center">
              View All {{ $category->name }} <i class="fas fa-arrow-right ms-2"></i>
            </a>
          </div>

          <div class="d-block d-md-none mb-4">
            <a href="{{ route('shop.index', ['category' => $category->slug]) }}"
               class="btn btn-primary w-100 btn-lg">
              View All {{ $category->name }} <i class="fas fa-arrow-right ms-2"></i>
            </a>
          </div>

          <div class="row g-4">
            @foreach($category->products->take(4) as $product)
              <div class="col-md-4 col-lg-3">
                <div class="card product-card h-100 shadow-sm">
                  @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}"
                         class="card-img-top product-img"
                         alt="{{ $product->name }}">
                  @else
                    <div class="card-img-top product-img bg-light d-flex align-items-center justify-content-center">
                      <i class="fas fa-image fa-3x text-muted"></i>
                    </div>
                  @endif
                  <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-truncate">{{ $product->name }}</h5>
                    <p class="card-text text-muted small">{{ Str::limit($product->description, 80) }}</p>

                    <div class="mt-auto">
                      <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 text-primary mb-0">${{ number_format($product->price, 2) }}</span>
                        <a href="{{ route('shop.show', $product) }}"
                           class="btn btn-outline-primary btn-sm rounded-pill">
                          <i class="fas fa-cart-plus me-2"></i>Add to Cart
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif
    @endforeach
  </div>

  <!-- Features Section -->
  <div class="bg-light py-5">
    <div class="container">
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card feature-card h-100 border-0 shadow-hover">
            <div class="card-body text-center p-4">
              <div class="icon-wrapper bg-primary rounded-circle mb-3">
                <i class="fas fa-truck fa-2x text-white"></i>
              </div>
              <h5 class="card-title">Fast & Free Shipping</h5>
              <p class="card-text text-muted">Enjoy free delivery on all orders over $50</p>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card feature-card h-100 border-0 shadow-hover">
            <div class="card-body text-center p-4">
              <div class="icon-wrapper bg-primary rounded-circle mb-3">
                <i class="fas fa-shield-alt fa-2x text-white"></i>
              </div>
              <h5 class="card-title">Secure Checkout</h5>
              <p class="card-text text-muted">256-bit SSL secure payment processing</p>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card feature-card h-100 border-0 shadow-hover">
            <div class="card-body text-center p-4">
              <div class="icon-wrapper bg-primary rounded-circle mb-3">
                <i class="fas fa-smile fa-2x text-white"></i>
              </div>
              <h5 class="card-title">Satisfaction Guarantee</h5>
              <p class="card-text text-muted">30-day money back return policy</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
