@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('styles')
  <style>
    .cart-item-image {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 5px;
    }

    .quantity-control {
      max-width: 120px;
    }

    .summary-card {
      position: sticky;
      top: 20px;
    }

    .shipping-info-card {
      margin-top: 20px;
    }

    /* Mobile optimizations */
    @media (max-width: 767.98px) {
      .mobile-cart-item {
        border-bottom: 1px solid #eee;
        padding: 15px 0;
      }

      .mobile-cart-item:last-child {
        border-bottom: none;
      }

      .quantity-control {
        max-width: 100%;
      }

      .cart-item-details {
        padding-left: 15px;
      }

      .summary-card {
        margin-top: 20px;
        position: relative;
      }

      .mobile-price-row {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
      }

      .mobile-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
      }

      .mobile-product-title {
        font-weight: 500;
        margin-bottom: 5px;
      }
    }
  </style>
@endsection

@section('content')
  <div class="container py-4">
    <h2 class="mb-4">Shopping Cart</h2>

    @if ($cartItems->isEmpty())
      <div class="alert alert-info">
        <i class="fas fa-shopping-cart me-2"></i>
        Your cart is empty. <a href="{{ route('shop.index') }}" class="alert-link">Continue shopping</a>.
      </div>
    @else
      <div class="row">
        <!-- Cart Items Section -->
        <div class="col-lg-8 mb-4">
          <div class="card shadow-sm">
            <div class="card-header bg-white">
              <h5 class="mb-0">Cart Items</h5>
            </div>

            <!-- Desktop view -->
            <div class="card-body d-none d-md-block">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Product</th>
                      <th>Price</th>
                      <th>Quantity</th>
                      <th>Subtotal</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($cartItems as $item)
                      <tr>
                        <td class="align-middle">
                          <div class="d-flex align-items-center">
                            @if ($item->product->image)
                              <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}"
                                class="cart-item-image me-3">
                            @else
                              <img src="https://via.placeholder.com/60x60?text=No+Image" alt="No Image"
                                class="cart-item-image me-3">
                            @endif
                            <a href="{{ route('shop.show', $item->product) }}" class="text-decoration-none text-dark">
                              {{ $item->product->name }}
                            </a>
                          </div>
                        </td>
                        <td class="align-middle">${{ number_format($item->product->price, 2) }}</td>
                        <td class="align-middle">
                          <form action="{{ route('cart.update', $item) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <div class="input-group quantity-control">
                              <button class="btn btn-sm btn-outline-secondary" type="button"
                                onclick="decrementQuantity('quantity-{{ $item->id }}')">
                                <i class="fas fa-minus"></i>
                              </button>
                              <input type="number" class="form-control form-control-sm text-center" name="quantity"
                                id="quantity-{{ $item->id }}" value="{{ $item->quantity }}" min="1"
                                max="{{ $item->product->stock }}">
                              <button class="btn btn-sm btn-outline-secondary" type="button"
                                onclick="incrementQuantity('quantity-{{ $item->id }}', {{ $item->product->stock }})">
                                <i class="fas fa-plus"></i>
                              </button>
                            </div>
                            <button type="submit" class="btn btn-sm btn-outline-primary mt-2">
                              <i class="fas fa-sync-alt me-1"></i> Update
                            </button>
                          </form>
                        </td>
                        <td class="align-middle fw-bold">${{ number_format($item->product->price * $item->quantity, 2) }}
                        </td>
                        <td class="align-middle">
                          <form action="{{ route('cart.remove', $item) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"
                              onclick="return confirm('Are you sure you want to remove this item?')">
                              <i class="fas fa-trash"></i>
                            </button>
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Mobile view -->
            <div class="card-body d-md-none">
              @foreach ($cartItems as $item)
                <div class="mobile-cart-item">
                  <div class="d-flex">
                    <!-- Product image -->
                    <div>
                      @if ($item->product->image)
                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}"
                          class="cart-item-image">
                      @else
                        <img src="https://via.placeholder.com/60x60?text=No+Image" alt="No Image" class="cart-item-image">
                      @endif
                    </div>

                    <!-- Product details -->
                    <div class="cart-item-details flex-grow-1">
                      <h6 class="mobile-product-title">
                        <a href="{{ route('shop.show', $item->product) }}" class="text-decoration-none text-dark">
                          {{ $item->product->name }}
                        </a>
                      </h6>

                      <div class="mobile-price-row">
                        <span class="text-muted">Unit Price:</span>
                        <span>${{ number_format($item->product->price, 2) }}</span>
                      </div>

                      <div class="mobile-price-row">
                        <span class="text-muted">Subtotal:</span>
                        <span class="fw-bold">${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                      </div>

                      <!-- Quantity control -->
                      <div class="my-3">
                        <form action="{{ route('cart.update', $item) }}" method="POST">
                          @csrf
                          @method('PATCH')
                          <div class="d-flex align-items-center">
                            <label class="text-muted me-2">Qty:</label>
                            <div class="input-group quantity-control me-2">
                              <button class="btn btn-sm btn-outline-secondary" type="button"
                                onclick="decrementQuantity('mobile-quantity-{{ $item->id }}')">
                                <i class="fas fa-minus"></i>
                              </button>
                              <input type="number" class="form-control form-control-sm text-center" name="quantity"
                                id="mobile-quantity-{{ $item->id }}" value="{{ $item->quantity }}" min="1"
                                max="{{ $item->product->stock }}">
                              <button class="btn btn-sm btn-outline-secondary" type="button"
                                onclick="incrementQuantity('mobile-quantity-{{ $item->id }}', {{ $item->product->stock }})">
                                <i class="fas fa-plus"></i>
                              </button>
                            </div>
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                              <i class="fas fa-sync-alt"></i>
                            </button>
                          </div>
                        </form>
                      </div>

                      <!-- Remove button -->
                      <div class="mobile-actions">
                        <form action="{{ route('cart.remove', $item) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-outline-danger"
                            onclick="return confirm('Are you sure you want to remove this item?')">
                            <i class="fas fa-trash me-1"></i> Remove
                          </button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>

        <!-- Right Column: Order Summary & Shipping Info -->
        <div class="col-lg-4">
          <!-- Order Summary Card -->
          <div class="card shadow-sm summary-card">
            <div class="card-header bg-white">
              <h5 class="mb-0">
                <i class="fas fa-receipt text-primary me-2"></i>
                Order Summary
              </h5>
            </div>
            <div class="card-body">
              <div class="d-flex justify-content-between mb-3">
                <span>Subtotal:</span>
                <span>${{ number_format($total, 2) }}</span>
              </div>
              <div class="d-flex justify-content-between mb-3">
                <span>Shipping Fee:</span>
                @if ($shippingFee > 0)
                  <span>${{ number_format($shippingFee, 2) }}</span>
                @else
                  <span class="text-success">Free</span>
                @endif
              </div>
              <hr>
              <div class="d-flex justify-content-between mb-3">
                <strong>Total:</strong>
                <strong class="text-primary fs-5">${{ number_format($grandTotal, 2) }}</strong>
              </div>
              <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100 py-2">
                <i class="fas fa-shopping-bag me-2"></i> Proceed to Checkout
              </a>
              <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                <i class="fas fa-arrow-left me-2"></i> Continue Shopping
              </a>
            </div>
          </div>

          <!-- Shipping Information Card -->
          <div class="card shadow-sm shipping-info-card">
            <div class="card-header bg-white">
              <h5 class="mb-0">
                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                Shipping Information
              </h5>
            </div>
            <div class="card-body">
              @if (Auth::user()->address)
                <div class="mb-2">
                  <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-home text-muted me-2"></i>
                    <strong>Address:</strong>
                  </div>
                  <p class="ps-4 mb-3">{{ Auth::user()->address }}</p>
                </div>
              @else
                <div class="alert alert-warning mb-3">
                  <i class="fas fa-exclamation-triangle me-2"></i>
                  No shipping address provided.
                </div>
              @endif

              @if (Auth::user()->phone)
                <div class="mb-3">
                  <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-phone text-muted me-2"></i>
                    <strong>Phone:</strong>
                  </div>
                  <p class="ps-4 mb-2">{{ Auth::user()->phone }}</p>
                </div>
              @else
                <div class="alert alert-warning mb-3">
                  <i class="fas fa-exclamation-triangle me-2"></i>
                  No phone number provided.
                </div>
              @endif

              <button type="button" class="btn btn-outline-secondary w-100" data-bs-toggle="modal"
                data-bs-target="#updateInfoModal">
                <i class="fas fa-edit me-1"></i> Update Information
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Updated modal for editing both address and phone -->
      <div class="modal fade" id="updateInfoModal" tabindex="-1" aria-labelledby="updateInfoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="updateInfoModalLabel">
                <i class="fas fa-user-edit text-primary me-2"></i>
                Update Shipping Information
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('user.update-info') }}" method="POST">
              @csrf
              <div class="modal-body">
                <div class="mb-3">
                  <label for="phone" class="form-label">
                    <i class="fas fa-phone text-muted me-1"></i> Phone Number
                  </label>
                  <input type="tel" name="phone" id="phone" class="form-control"
                    value="{{ old('phone', Auth::user()->phone) }}" required>
                  <small class="text-muted">Please enter your contact phone number</small>
                </div>

                <div class="mb-3">
                  <label for="address" class="form-label">
                    <i class="fas fa-map-marker-alt text-muted me-1"></i> Shipping Address
                  </label>
                  <textarea name="address" id="address" rows="4" class="form-control"
                    placeholder="Enter your complete shipping address" required>{{ old('address', Auth::user()->address) }}</textarea>
                  <small class="text-muted">Please include street address, apartment/unit number, city, state, and zip
                    code.</small>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save me-1"></i> Save Information
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    @endif
  </div>
@endsection

@section('scripts')
  <script>
    // Handle quantity increment/decrement for both desktop and mobile
    function incrementQuantity(inputId, maxStock) {
      const input = document.getElementById(inputId);
      const currentValue = parseInt(input.value, 10);

      if (currentValue < maxStock) {
        input.value = currentValue + 1;
      } else {
        // Show max stock reached notification
        showNotification('Maximum available stock reached!', 'warning');
      }
    }

    function decrementQuantity(inputId) {
      const input = document.getElementById(inputId);
      const currentValue = parseInt(input.value, 10);

      if (currentValue > 1) {
        input.value = currentValue - 1;
      }
    }

    // Toast notification function
    function showNotification(message, type = 'info') {
      const toastContainer = document.createElement('div');
      toastContainer.style.position = 'fixed';
      toastContainer.style.bottom = '20px';
      toastContainer.style.right = '20px';
      toastContainer.style.zIndex = '9999';

      const toast = document.createElement('div');
      toast.className = `toast align-items-center bg-${type} text-white border-0`;
      toast.setAttribute('role', 'alert');
      toast.setAttribute('aria-live', 'assertive');
      toast.setAttribute('aria-atomic', 'true');

      toast.innerHTML = `
      <div class="d-flex">
        <div class="toast-body">
          ${message}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    `;

      toastContainer.appendChild(toast);
      document.body.appendChild(toastContainer);

      const bsToast = new bootstrap.Toast(toast, {
        autohide: true,
        delay: 3000
      });

      bsToast.show();

      // Clean up after hiding
      toast.addEventListener('hidden.bs.toast', function() {
        document.body.removeChild(toastContainer);
      });
    }

    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });
    });
  </script>
@endsection
