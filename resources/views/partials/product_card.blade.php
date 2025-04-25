<div class="card h-100 border-0 hover-scale shadow-sm position-relative product-card">
  @if ($product->discount_price)
    <div class="position-absolute top-0 start-0 badge bg-danger discount-badge">
      <span
        class="fs-6 fw-bold">{{ number_format((($product->price - $product->discount_price) / $product->price) * 100, 0) }}%
        OFF</span>
    </div>
  @endif

  <!-- Wishlist button -->
  <button class="position-absolute top-0 end-0 btn btn-light rounded-circle m-2 p-2 wishlist-btn"
    aria-label="Add to wishlist">
    <i class="far fa-heart"></i>
  </button>

  <div class="card-img-top overflow-hidden position-relative">
    <a href="{{ route('shop.show', $product) }}" class="d-block product-img-container">
      @if ($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid product-image" alt="{{ $product->name }}"
          loading="lazy">
        <!-- Add second image for hover effect if available -->
        @if (isset($product->images) && count($product->images) > 0)
          <img src="{{ asset('storage/' . $product->images[0]) }}" class="img-fluid product-image-hover"
            alt="{{ $product->name }}" loading="lazy">
        @endif
      @else
        <div class="placeholder-image d-flex align-items-center justify-content-center bg-light">
          <i class="fas fa-image fa-3x text-secondary"></i>
          <span class="sr-only">No image available</span>
        </div>
      @endif
    </a>

    <!-- Quick view button -->
    <div class="quick-actions d-flex justify-content-center">
      <button class="btn btn-light quick-view-btn" data-product-id="{{ $product->id }}"
        aria-label="Quick view {{ $product->name }}">
        <i class="fas fa-eye me-2"></i>Quick View
      </button>
    </div>
  </div>

  <div class="card-body pb-0 d-flex flex-column">
    <!-- Product category badge -->
    @if ($product->category)
      <div class="mb-2">
        <span class="badge bg-light text-dark">{{ $product->category->name }}</span>
      </div>
    @endif

    <h5 class="card-title mb-2 product-title">
      <a href="{{ route('shop.show', $product) }}" class="text-dark text-decoration-none">
        {{ Str::limit($product->name, 40) }}
      </a>
    </h5>

    <!-- Product rating -->
    <div class="d-flex align-items-center mb-2">
      <div class="ratings">
        @php $rating = $product->average_rating ?? 4.5; @endphp
        @for ($i = 1; $i <= 5; $i++)
          <i class="fa{{ $i <= $rating ? 's' : 'r' }} fa-star text-warning"></i>
        @endfor
      </div>
      <small class="ms-2 text-muted">({{ $product->reviews_count ?? rand(5, 50) }})</small>
    </div>

    <div class="d-flex align-items-center justify-content-between mb-3 mt-auto">
      <div class="price-wrapper">
        @if ($product->discount_price)
          <span class="text-muted text-decoration-line-through me-2 fs-6">
            ${{ number_format($product->price, 2) }}
          </span>
          <span class="h5 text-success fw-bold mb-0">
            ${{ number_format($product->discount_price, 2) }}
          </span>
        @else
          <span class="h5 fw-bold text-dark mb-0">
            ${{ number_format($product->price, 2) }}
          </span>
        @endif
      </div>
      @if (($product->discount_price ?? $product->price) > 1000)
        <span class="shipping-icon" data-bs-toggle="tooltip" title="Free Shipping">
          <i class="fas fa-shipping-fast text-success fs-5"></i>
        </span>
      @endif
    </div>
  </div>

  <div class="card-footer bg-transparent border-top-0 pb-3">
    <div class="d-flex gap-2">
      <a href="{{ route('shop.show', $product) }}" class="btn btn-primary w-100">
        <i class="fas fa-shopping-cart me-2"></i>
        Add to Cart
      </a>
      <!-- Compare button -->
      <button class="btn btn-outline-secondary compare-btn" data-product-id="{{ $product->id }}"
        aria-label="Compare {{ $product->name }}">
        <i class="fas fa-exchange-alt"></i>
      </button>
    </div>

    <!-- Stock status -->
    @if (isset($product->stock) && $product->stock > 0)
      @if ($product->stock < 5)
        <div class="mt-2 text-danger small">
          <i class="fas fa-exclamation-circle me-1"></i>
          Only {{ $product->stock }} left in stock
        </div>
      @endif
    @endif
  </div>
</div>
