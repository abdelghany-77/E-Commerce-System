@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
  <div class="container py-5">
    <div class="row g-4">
      <!-- Checkout Progress -->
      <div class="col-12">
        <div class="checkout-progress d-flex justify-content-center mb-5">
          <div class="step active">
            <span class="step-number">1</span>
            <span class="step-text">Cart</span>
          </div>
          <div class="step-divider"></div>
          <div class="step active">
            <span class="step-number">2</span>
            <span class="step-text">Details</span>
          </div>
          <div class="step-divider"></div>
          <div class="step">
            <span class="step-number">3</span>
            <span class="step-text">Payment</span>
          </div>
        </div>
      </div>

      <!-- Shipping Information -->
      <div class="col-lg-8">
        <div class="card shadow-sm mb-4">
          <div class="card-header bg-white border-bottom py-3">
            <h5 class="mb-0"><i class="fas fa-truck me-2 text-primary"></i>Shipping Details</h5>
          </div>
          <div class="card-body">
            <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form" class="needs-validation"
              novalidate>
              @csrf
              <div class="row g-3">
                <div class="col-12">
                  <label for="shipping_address" class="form-label">Shipping Address</label>
                  <textarea name="shipping_address" id="shipping_address" rows="4"
                    class="form-control @error('shipping_address') is-invalid @enderror" required>{{ old('shipping_address', Auth::user()->address) }}</textarea>
                  @error('shipping_address')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <!-- Payment Methods -->
              <div class="mt-5 pt-4 border-top">
                <h5 class="mb-4"><i class="fas fa-credit-card me-2 text-primary"></i>Payment Method</h5>
                <div class="payment-method-card active">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" id="cash_on_delivery"
                      value="cash_on_delivery" checked>
                    <label class="form-check-label" for="cash_on_delivery">
                      <div class="d-flex align-items-center">
                        <div class="payment-method-icon">
                          <i class="fas fa-hand-holding-usd fa-2x text-muted"></i>
                        </div>
                        <div class="ms-3">
                          <h6 class="mb-1">Cash on Delivery</h6>
                          <p class="small text-muted mb-0">Pay when you receive your order</p>
                        </div>
                      </div>
                    </label>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Order Summary -->
      <div class="col-lg-4">
        <div class="card shadow-sm sticky-top" style="top: 20px;">
          <div class="card-header bg-white border-bottom py-3">
            <h5 class="mb-0"><i class="fas fa-receipt me-2 text-primary"></i>Order Summary</h5>
          </div>
          <div class="card-body">
            <div class="list-group list-group-flush mb-3">
              @foreach ($cartItems as $item)
                <div class="list-group-item px-0">
                  <div class="d-flex justify-content-between">
                    <div class="d-flex">
                      @if ($item->product->image)
                        <img src="{{ asset('storage/' . $item->product->image) }}" class="checkout-product-img me-3"
                          alt="{{ $item->product->name }}">
                      @else
                        <div class="checkout-product-img bg-light me-3">
                          <i class="fas fa-image text-muted"></i>
                        </div>
                      @endif
                      <div>
                        <h6 class="mb-1">{{ Str::limit($item->product->name, 20) }}</h6>
                        <small class="text-muted">Qty: {{ $item->quantity }}</small>
                      </div>
                    </div>
                    <span class="text-end">${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                  </div>
                </div>
              @endforeach
            </div>

            <dl class="row mb-3">
              <dt class="col-6">Subtotal:</dt>
              <dd class="col-6 text-end">${{ number_format($total, 2) }}</dd>
              <dt class="col-6">Shipping:</dt>
              <dd class="col-6 text-end">
                @if ($shippingFee > 0)
                  <span>${{ number_format($shippingFee, 2) }}</span>
                @else
                  <span class="text-success">Free</span>
                @endif
              </dd>
            </dl>
            <hr class="my-4">

            <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
              <span>Total:</span>
              <strong class="text-primary fs-5">${{ number_format($grandTotal, 2) }}</strong>
            </div>

            <button type="submit" class="btn btn-primary w-100 btn-lg" form="checkout-form">
              Place Order
              <div class="spinner-border spinner-border-sm ms-2 d-none" role="status"></div>
            </button>

            <p class="small text-muted mt-3 text-center">
              By placing your order, you agree to our
              <a href="#" class="text-decoration-none">Terms of Service</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    (function() {
      'use strict'

      // Form validation
      const form = document.getElementById('checkout-form')
      const submitBtn = form.querySelector('button[type="submit"]')

      form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        } else {
          submitBtn.disabled = true
          submitBtn.querySelector('.spinner-border').classList.remove('d-none')
        }

        form.classList.add('was-validated')
      }, false)

      // Payment method selection
      document.querySelectorAll('.payment-method-card').forEach(card => {
        card.addEventListener('click', () => {
          document.querySelectorAll('.payment-method-card').forEach(c => {
            c.classList.remove('active')
          })
          card.classList.add('active')
          card.querySelector('input[type="radio"]').checked = true
        })
      })
    })()
  </script>
@endsection
