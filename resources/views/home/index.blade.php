@extends('layouts.app')

@section('title', 'E-Shop - Quality Products at Great Prices')

@section('meta')
  <meta name="description"
    content="Shop the best products at E-Shop. Enjoy free shipping, flash sales, and excellent customer service.">
@endsection

@section('styles')
  <style>
    .hero-section {
      background: linear-gradient(135deg, #377dff 0%, #ff6b35 100%);
      background-size: 200% 200%;
      color: #fff;
      min-height: 420px;
      clip-path: ellipse(110% 100% at 50% 0%);
      transition: all 0.3s ease;
      animation: gradientBG 15s ease infinite;
    }

    @keyframes gradientBG {
      0% {
        background-position: 0% 50%;
      }

      50% {
        background-position: 100% 50%;
      }

      100% {
        background-position: 0% 50%;
      }
    }

    .hero-section:hover {
      clip-path: ellipse(120% 105% at 50% 0%);
    }

    .hero-section .btn-hero {
      background: #ffffff;
      color: #377dff;
      border: none;
      padding: 1rem 2.5rem;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .hero-section .btn-hero:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    /* Enhanced Product Grid */
    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 1.5rem;
    }

    /* Section Headers */
    .section-header {
      position: relative;
      margin-bottom: 2.5rem;
    }

    .section-title {
      position: relative;
      display: inline-block;
      padding-bottom: 0.5rem;
    }

    .section-title::after {
      content: '';
      position: absolute;
      left: 50%;
      bottom: 0;
      width: 80px;
      height: 4px;
      background: linear-gradient(to right, #ff6b35, #377dff);
      border-radius: 10px;
    }

    /* Category Navigation */
    .category-nav {
      overflow-x: auto;
      white-space: nowrap;
      scrollbar-width: thin;
      padding-bottom: 1rem;
      margin-bottom: 2rem;
    }

    .category-nav::-webkit-scrollbar {
      height: 4px;
    }

    .category-nav::-webkit-scrollbar-thumb {
      background-color: rgba(0, 0, 0, 0.2);
      border-radius: 10px;
    }

    .category-nav .nav-link {
      padding: 0.6rem 1.2rem;
      margin-right: 0.5rem;
      border-radius: 20px;
      color: #495057;
      background-color: #f8f9fa;
      transition: all 0.2s;
    }

    .category-nav .nav-link:hover,
    .category-nav .nav-link.active {
      background-color: #377dff;
      color: white;
    }

    /* Product Card Styles */
    .product-card {
      transition: all 0.3s ease;
      overflow: hidden;
    }

    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
    }

    .product-img-container {
      height: 220px;
      position: relative;
      overflow: hidden;
    }

    .product-image,
    .product-image-hover {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: all 0.5s ease;
    }

    .product-image-hover {
      position: absolute;
      top: 0;
      left: 0;
      opacity: 0;
    }

    .product-card:hover .product-image {
      /* opacity: 0; */
    }

    .product-card:hover .product-image-hover {
      opacity: 1;
    }

    .quick-actions {
      position: absolute;
      bottom: -50px;
      left: 0;
      right: 0;
      transition: all 0.3s ease;
      opacity: 0;
    }

    .product-card:hover .quick-actions {
      bottom: 10px;
      opacity: 1;
    }

    .wishlist-btn {
      opacity: 0.7;
      transition: all 0.3s ease;
    }

    .wishlist-btn:hover {
      background-color: #ff6b35;
      color: white;
      opacity: 1;
    }

    .discount-badge {
      padding: 0.5rem;
      z-index: 5;
    }

    /* Sale Timer */
    .sale-countdown {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      background: rgba(255, 255, 255, 0.2);
      padding: 0.5rem 1rem;
      border-radius: 20px;
      font-weight: 500;
    }

    .countdown-box {
      display: inline-block;
      text-align: center;
      min-width: 40px;
    }

    .countdown-value {
      font-size: 1.2rem;
      font-weight: 700;
      margin: 0;
      line-height: 1;
    }

    .countdown-label {
      font-size: 0.7rem;
      text-transform: uppercase;
    }

    /* Featured Categories */
    .featured-category {
      position: relative;
      overflow: hidden;
      border-radius: 10px;
      margin-bottom: 1.5rem;
    }

    .featured-category img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      transition: transform 0.5s;
    }

    .featured-category:hover img {
      transform: scale(1.1);
    }

    .featured-category-content {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      padding: 1rem;
      background: linear-gradient(0deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0) 100%);
      color: white;
    }

    /* Feature Cards */
    .feature-card {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .feature-card:hover {
      transform: translateY(-8px);
    }

    .icon-wrapper {
      width: 70px;
      height: 70px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto;
      transition: all 0.3s ease;
    }

    .feature-card:hover .icon-wrapper {
      transform: rotateY(180deg);
    }

    /* Newsletter Section */
    .newsletter-section {
      background-color: #f8f9fa;
      padding: 3rem 0;
      border-radius: 10px;
      margin: 2rem 0;
    }

    .newsletter-form {
      max-width: 500px;
      margin: 0 auto;
    }

    /* Mobile Optimization */
    @media (max-width: 767px) {
      .hero-section {
        min-height: 300px;
        padding: 2rem 0;
      }

      .hero-section h1 {
        font-size: 2rem;
        line-height: 1.3;
      }

      .product-grid {
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      }

      .product-img-container {
        height: 180px;
      }
    }
  </style>
@endsection

@section('content')
  <!-- Hero Section with Dynamic Background -->
  <div class="hero-section py-5 mb-4 d-flex align-items-center">
    <div class="container text-center">
      <h1 class="display-4 fw-bold mb-3">Welcome to <span class="text-warning">E-Shop</span></h1>
      <p class="lead mb-4">Discover amazing products at great prices.<br class="d-none d-md-inline">
        Shop now and enjoy fast shipping and excellent customer service!</p>
      <div class="d-flex justify-content-center gap-3">
        <a class="btn btn-hero btn-lg px-5 rounded-pill shadow fw-semibold" href="{{ route('shop.index') }}">
          Start Shopping <i class="fas fa-arrow-right ms-2"></i>
        </a>
        <a class="btn btn-outline-light btn-lg rounded-pill" href="#flash-sales">
          Today's Deals <i class="fas fa-tags ms-2"></i>
        </a>
      </div>
    </div>
  </div>

  <div class="container">
    <!-- Category Navigation -->
    <div class="category-nav">
      <nav class="nav">
        <a class="nav-link active" href="{{ route('shop.index') }}">All Products</a>
        @foreach ($categories as $cat)
          <a class="nav-link" href="{{ route('shop.index', ['category' => $cat->slug]) }}">
            {{ $cat->name }}
          </a>
        @endforeach
      </nav>
    </div>

    <!-- Flash Sales Section with Countdown -->
    @if ($flashSales->count())
      <section class="my-5" id="flash-sales">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div class="section-header mb-0">
            <h2 class="section-title">🔥 Flash Sales</h2>
          </div>
          <div class="sale-countdown text-white">
            <i class="fas fa-clock"></i>
            <div class="countdown-box">
              <p class="countdown-value" id="hours">24</p>
              <span class="countdown-label">hrs</span>
            </div>
            <span>:</span>
            <div class="countdown-box">
              <p class="countdown-value" id="minutes">00</p>
              <span class="countdown-label">min</span>
            </div>
            <span>:</span>
            <div class="countdown-box">
              <p class="countdown-value" id="seconds">00</p>
              <span class="countdown-label">sec</span>
            </div>
          </div>
          <a href="{{ route('shop.index', ['flash' => 'sale']) }}"
            class="btn btn-outline-danger btn-sm d-none d-md-inline-flex">
            View All <i class="fas fa-chevron-right ms-2"></i>
          </a>
        </div>

        <div class="product-grid">
          @foreach ($flashSales as $product)
            <div class="grid-item">
              @include('partials.product_card', ['product' => $product])
            </div>
          @endforeach
        </div>

        <div class="d-block d-md-none mt-4">
          <a href="{{ route('shop.index', ['flash' => 'sale']) }}" class="btn btn-outline-danger w-100">
            View All Flash Sales
          </a>
        </div>
      </section>
    @endif

    <!-- Free Shipping Section -->
    @if ($freeShippingProducts->count())
      <section class="my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div class="section-header mb-0">
            <h2 class="section-title text-success"><strong>🚚 Free Shipping</strong></h2>
          </div>
          <a href="{{ route('shop.index', ['shipping' => 'free']) }}"
            class="btn btn-outline-success btn-sm d-none d-md-inline-flex">
            View All <i class="fas fa-chevron-right ms-2"></i>
          </a>
        </div>

        <div class="product-grid">
          @foreach ($freeShippingProducts as $product)
            <div class="grid-item">
              @include('partials.product_card', ['product' => $product])
            </div>
          @endforeach
        </div>

        <div class="d-block d-md-none mt-4">
          <a href="{{ route('shop.index', ['shipping' => 'free']) }}" class="btn btn-outline-success w-100">
            View All Free Shipping Products
          </a>
        </div>
      </section>
    @endif

    <!-- Products by Categories -->
    @foreach ($categories as $category)
      @if ($category->products->isNotEmpty())
        <section class="my-5 category-section">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="section-header mb-0">
              <h2 class="section-title">{{ $category->name }}</h2>
              @if (isset($category->description))
                <p class="text-muted mb-0">{{ Str::limit($category->description, 120) }}</p>
              @endif
            </div>
            <a href="{{ route('shop.index', ['category' => $category->slug]) }}"
              class="btn btn-outline-primary btn-sm d-none d-md-inline-flex">
              View All {{ $category->name }} <i class="fas fa-chevron-right ms-2"></i>
            </a>
          </div>

          <div class="product-grid">
            @foreach ($category->products->take(4) as $product)
              <div class="grid-item">
                @include('partials.product_card', ['product' => $product])
              </div>
            @endforeach
          </div>

          <div class="d-block d-md-none mt-4">
            <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="btn btn-outline-primary w-100">
              View All {{ $category->name }}
            </a>
          </div>
        </section>
      @endif
    @endforeach

    <!-- Features Section -->
    <div class="bg-light py-5 mt-5">
      <div class="container">
        <div class="row g-4">
          <div class="col-md-3">
            <div class="card feature-card h-100 border-0 shadow-sm">
              <div class="card-body text-center p-4">
                <div class="icon-wrapper bg-primary rounded-circle mb-3">
                  <i class="fas fa-truck fa-2x text-white"></i>
                </div>
                <h5 class="card-title">Fast & Free Shipping</h5>
                <p class="card-text text-muted">Enjoy free delivery on all orders over $1000</p>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="card feature-card h-100 border-0 shadow-sm">
              <div class="card-body text-center p-4">
                <div class="icon-wrapper bg-primary rounded-circle mb-3">
                  <i class="fas fa-shield-alt fa-2x text-white"></i>
                </div>
                <h5 class="card-title">Secure Checkout</h5>
                <p class="card-text text-muted">256-bit SSL secure payment processing</p>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="card feature-card h-100 border-0 shadow-sm">
              <div class="card-body text-center p-4">
                <div class="icon-wrapper bg-primary rounded-circle mb-3">
                  <i class="fas fa-smile fa-2x text-white"></i>
                </div>
                <h5 class="card-title">Satisfaction Guarantee</h5>
                <p class="card-text text-muted">30-day money back return policy</p>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="card feature-card h-100 border-0 shadow-sm">
              <div class="card-body text-center p-4">
                <div class="icon-wrapper bg-primary rounded-circle mb-3">
                  <i class="fas fa-headset fa-2x text-white"></i>
                </div>
                <h5 class="card-title">24/7 Support</h5>
                <p class="card-text text-muted">Customer service available around the clock</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endsection

  @section('scripts')
    <script>
      // Initialize tooltips
      document.addEventListener('DOMContentLoaded', function() {
        var tooltips = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltips.map(function(tooltip) {
          return new bootstrap.Tooltip(tooltip);
        });

        // Sale countdown timer
        function updateCountdown() {
          // Set your end date here or pull from backend
          const now = new Date();
          const endOfDay = new Date();
          endOfDay.setHours(23, 59, 59, 999);

          const diff = endOfDay - now;

          if (diff > 0) {
            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
            document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
            document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
          }
        }

        // Initial call and set interval
        updateCountdown();
        setInterval(updateCountdown, 1000);

        // Add to wishlist functionality
        const wishlistBtns = document.querySelectorAll('.wishlist-btn');
        wishlistBtns.forEach(btn => {
          btn.addEventListener('click', function(e) {
            e.preventDefault();
            const icon = this.querySelector('i');
            if (icon.classList.contains('far')) {
              icon.classList.replace('far', 'fas');
              icon.classList.add('text-danger');
            } else {
              icon.classList.replace('fas', 'far');
              icon.classList.remove('text-danger');
            }
          });
        });

        // Quick view functionality placeholder
        const quickViewBtns = document.querySelectorAll('.quick-view-btn');
        quickViewBtns.forEach(btn => {
          btn.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            console.log('Quick view for product ID:', productId);
            // Add your modal opening code here
          });
        });

        // Add to cart functionality placeholder
        const addToCartBtns = document.querySelectorAll('.add-to-cart-btn');
        addToCartBtns.forEach(btn => {
          btn.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            console.log('Adding to cart product ID:', productId);
            // Add your cart functionality here

            // Animation effect
            this.classList.add('btn-success');
            this.innerHTML = '<i class="fas fa-check me-2"></i>Added!';

            setTimeout(() => {
              this.classList.remove('btn-success');
              this.innerHTML = '<i class="fas fa-cart-plus me-2"></i>Add to Cart';
            }, 2000);
          });
        });
      });
    </script>
  @endsection
