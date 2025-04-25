@extends('layouts.app')

@section('title', $product->name)

@section('content')
  <div class="container">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" class="mb-4">
      <ol class="breadcrumb flex-nowrap overflow-auto pb-2">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('shop.index') }}">Shop</a></li>
        <li class="breadcrumb-item active text-truncate" aria-current="page">{{ $product->name }}</li>
      </ol>
    </nav>

    <!-- Product Details -->
    <div class="row g-4 mb-5">
      <!-- Product Image -->
      <div class="col-lg-6">
        <div class="product-image-container position-relative bg-light rounded-3 overflow-hidden">
          @if ($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid w-100" alt="{{ $product->name }}"
              style="max-height: 500px; object-fit: contain;">
          @else
            <div class="d-flex align-items-center justify-content-center" style="height: 300px;">
              <i class="fas fa-image fa-4x text-muted"></i>
            </div>
          @endif
        </div>
      </div>

      <!-- Product Info -->
      <div class="col-lg-6">
        <div class="product-details">
          <h1 class="mb-3 fs-3 fs-lg-2">{{ $product->name }}</h1>

          <!-- Stock & Categories -->
          <div class="d-flex flex-wrap gap-2 mb-3">
            <span class="badge fs-6 {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }}">
              @if ($product->stock > 10)
                In Stock
              @elseif($product->stock > 0)
                Only {{ $product->stock }} left!
              @else
                Out of Stock
              @endif
            </span>
            @foreach ($product->categories as $category)
              <a href="{{ route('shop.index', ['category' => $category->slug]) }}"
                class="badge bg-secondary text-decoration-none fs-6">
                {{ $category->name }}
              </a>
            @endforeach
          </div>
          <!-- Price -->
          <div class="mb-3">
            @if ($product->discount_price)
              <span class="text-muted text-decoration-line-through fs-5">
                ${{ number_format($product->price, 2) }}
              </span>
              <span class="fw-bold text-danger fs-5 ms-2">
                ${{ number_format($product->discount_price, 2) }}
              </span>
            @else
              <span class="fw-bold fs-5">
                ${{ number_format($product->price, 2) }}
              </span>
            @endif
          </div>
          <!-- Description -->
          <div class="mb-4">
            <h5 class="fs-5">Description</h5>
            <p class="mb-0">{{ $product->description }}</p>
          </div>

          <!-- Add to Cart -->
          @if ($product->stock > 0)
            <form action="{{ route('cart.add') }}" method="POST">
              @csrf
              <input type="hidden" name="product_id" value="{{ $product->id }}">

              <div class="d-flex flex-column flex-sm-row align-items-start gap-3">
                <div class="input-group input-group-lg" style="max-width: 200px;">
                  <button class="btn btn-outline-secondary" type="button" onclick="decrementQuantity()">
                    <i class="fas fa-minus"></i>
                  </button>
                  <input type="number" class="form-control text-center" name="quantity" id="quantity" value="1"
                    min="1" max="{{ $product->stock }}">
                  <button class="btn btn-outline-secondary" type="button" onclick="incrementQuantity()">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100 w-sm-auto">
                  <i class="fas fa-cart-plus me-2"></i>Add to Cart
                </button>
              </div>
            </form>
          @else
            <button class="btn btn-secondary btn-lg w-100" disabled>
              <i class="fas fa-times-circle me-2"></i>Out of Stock
            </button>
          @endif
        </div>
      </div>
    </div>

    <!-- Related Products -->
    @if ($relatedProducts->count() > 0)
      <div class="related-products">
        <h3 class="mb-4">Related Products</h3>
        <div class="row g-3 flex-nowrap flex-lg-wrap overflow-auto pb-2">
          @foreach ($relatedProducts as $relatedProduct)
            <div class="col-10 col-sm-8 col-md-6 col-lg-3">
              <div class="card product-card h-100 shadow-sm">
                @if ($relatedProduct->image)
                  <img src="{{ asset('storage/' . $relatedProduct->image) }}" class="card-img-top product-img"
                    alt="{{ $relatedProduct->name }}" style="height: 200px; object-fit: contain;">
                @else
                  <div class="card-img-top product-img d-flex align-items-center justify-content-center bg-light"
                    style="height: 200px;">
                    <i class="fas fa-image fa-3x text-muted"></i>
                  </div>
                @endif
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title fs-6">{{ $relatedProduct->name }}</h5>
                  <p class="card-text text-muted small">{{ Str::limit($relatedProduct->description, 60) }}</p>
                  <div class="mt-auto">
                    <div class="d-flex justify-content-between align-items-center">
                      @if ($relatedProduct->discount_price)
                        <span class="text-muted text-decoration-line-through">
                          ${{ number_format($relatedProduct->price, 2) }}
                        </span>
                        <span class="fw-bold text-danger ms-2">
                          ${{ number_format($relatedProduct->discount_price, 2) }}
                        </span>
                      @else
                        <span class="fw-bold">
                          ${{ number_format($relatedProduct->price, 2) }}
                        </span>
                      @endif
                      <a href="{{ route('shop.show', $relatedProduct) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye d-none d-sm-inline-block"></i> Details
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
  </div>
@endsection

@section('scripts')
  <script>
    function incrementQuantity() {
      const input = document.getElementById('quantity');
      const max = parseInt(input.max);
      let value = parseInt(input.value) || 0;
      if (value < max) input.value = value + 1;
    }

    function decrementQuantity() {
      const input = document.getElementById('quantity');
      let value = parseInt(input.value) || 0;
      if (value > 1) input.value = value - 1;
    }

    document.getElementById('quantity').addEventListener('touchstart', (e) => {
      e.preventDefault();
      e.target.focus();
    });
  </script>
@endsection
