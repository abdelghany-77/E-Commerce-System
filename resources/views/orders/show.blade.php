@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
  <div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="my-4">
      <ol class="breadcrumb flex-nowrap overflow-auto pb-2">
        <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">My Orders</a></li>
        <li class="breadcrumb-item active text-truncate" aria-current="page">Order #{{ $order->order_number }}</li>
      </ol>
    </nav>

    <!-- Order Summary Card -->
    <div class="card shadow-sm mb-4">
      <div class="card-header bg-white py-3">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
          <h3 class="h5 mb-2 mb-md-0">Order Summary</h3>
          <div class="text-md-end text-muted small">
            Placed {{ $order->created_at->diffForHumans() }}<br class="d-md-none">
            <span class="d-md-none">{{ $order->created_at->format('M d, Y') }}</span>
          </div>
        </div>
      </div>

      <div class="card-body">
        <!-- Order Details Cards -->
        <div class="row g-3 mb-4">
          <div class="col-12 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
              <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                  <i class="fas fa-info-circle me-2 text-primary fs-5"></i>
                  <h5 class="card-title mb-0">Order Details</h5>
                </div>
                <dl class="row mb-0 small">
                  <dt class="col-5">Status:</dt>
                  <dd class="col-7">
                    @if ($order->status == 'pending')
                      <span class="badge bg-warning text-dark">Pending</span>
                    @elseif($order->status == 'processing')
                      <span class="badge bg-info">Processing</span>
                    @elseif($order->status == 'completed')
                      <span class="badge bg-success">Completed</span>
                    @elseif($order->status == 'canceled')
                      <span class="badge bg-danger">Cancelled</span>
                    @endif
                  </dd>

                  <dt class="col-5">Payment Method:</dt>
                  <dd class="col-7">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</dd>

                  <dt class="col-5">Total Amount:</dt>
                  <dd class="col-7 fw-bold">${{ number_format($order->total, 2) }}</dd>
                </dl>
              </div>
            </div>
          </div>

          <div class="col-12 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
              <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                  <i class="fas fa-truck me-2 text-primary fs-5"></i>
                  <h5 class="card-title mb-0">Shipping Info</h5>
                </div>
                <div class="small">
                  <div class="mb-2">{!! nl2br(e($order->shipping_address)) !!}</div>
                  @if ($order->user->phone)
                    <div class="d-flex align-items-center">
                      <i class="fas fa-phone me-2 text-muted"></i>
                      <span>{{ $order->user->phone }}</span>
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Order Items -->
        <div class="order-items">
          <div class="d-flex align-items-center mb-3">
            <i class="fas fa-box-open me-2 text-primary fs-5"></i>
            <h5 class="mb-0">Order Items</h5>
          </div>

          <!-- Mobile List -->
          <div class="d-md-none">
            @foreach ($order->items as $item)
              <div class="card mb-2 shadow-sm">
                <div class="card-body p-3">
                  <div class="d-flex align-items-start">
                    <!-- Product Image -->
                    <div class="flex-shrink-0 me-3">
                      @if ($item->product && $item->product->image)
                        <img src="{{ asset('storage/' . $item->product->image) }}" class="rounded-2"
                          alt="{{ $item->product->name }}" style="width: 60px; height: 60px; object-fit: cover;">
                      @else
                        <div class="bg-light rounded-2 d-flex align-items-center justify-content-center"
                          style="width: 60px; height: 60px;">
                          <i class="fas fa-image fa-lg text-muted"></i>
                        </div>
                      @endif
                    </div>

                    <!-- Product Details -->
                    <div class="flex-grow-1">
                      <h6 class="mb-1">
                        @if ($item->product)
                          <a href="{{ route('shop.show', $item->product) }}" class="text-decoration-none text-dark">
                            {{ $item->product->name }}
                          </a>
                        @else
                          <span class="text-muted">Product Unavailable</span>
                        @endif
                      </h6>

                      <div class="d-flex justify-content-between small text-muted">
                        <div>
                          <span class="d-block">Qty: {{ $item->quantity }}</span>
                          @if ($item->product && $item->product->discount_price)
                            <span class="d-block">
                              <s>${{ number_format($item->product->price, 2) }}</s>
                              <span class="text-danger">${{ number_format($item->product->discount_price, 2) }}
                                each</span>
                            </span>
                          @else
                            <span class="d-block">${{ number_format($item->price, 2) }} each</span>
                          @endif
                        </div>
                        <div class="text-end">
                          <span class="d-block fw-bold text-dark">
                            @if ($item->product && $item->product->discount_price)
                              ${{ number_format($item->product->discount_price * $item->quantity, 2) }}
                            @else
                              ${{ number_format($item->price * $item->quantity, 2) }}
                            @endif
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>

          <!-- Desktop Table -->
          <div class="d-none d-md-block">
            <div class="table-responsive">
              <table class="table table-borderless">
                <thead class="bg-light">
                  <tr>
                    <th style="width: 60px"></th>
                    <th>Product</th>
                    <th class="text-center">Qty</th>
                    <th class="text-end">Price</th>
                    <th class="text-end">Subtotal</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($order->items as $item)
                    <tr>
                      <td>
                        @if ($item->product && $item->product->image)
                          <img src="{{ asset('storage/' . $item->product->image) }}" class="rounded-2"
                            alt="{{ $item->product->name }}" style="width: 60px; height: 60px; object-fit: cover;">
                        @else
                          <div class="bg-light rounded-2 d-flex align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-image fa-lg text-muted"></i>
                          </div>
                        @endif
                      </td>
                      <td>
                        @if ($item->product)
                          <a href="{{ route('shop.show', $item->product) }}" class="text-decoration-none">
                            {{ $item->product->name }}
                          </a>
                        @else
                          <span class="text-muted">Product Unavailable</span>
                        @endif
                      </td>
                      <td class="text-center">{{ $item->quantity }}</td>
                      <td class="text-end">
                        @if ($item->product && $item->product->discount_price)
                          <s class="text-muted">${{ number_format($item->product->price, 2) }}</s>
                          <span class="text-danger">${{ number_format($item->product->discount_price, 2) }}</span>
                        @else
                          ${{ number_format($item->price, 2) }}
                        @endif
                      </td>
                      <td class="text-end fw-bold">
                        @if ($item->product && $item->product->discount_price)
                          ${{ number_format($item->product->discount_price * $item->quantity, 2) }}
                        @else
                          ${{ number_format($item->price * $item->quantity, 2) }}
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>

          <!-- Total Price & Shipping Fee -->
          <div class="card mt-3 border-0 bg-light shadow-sm">
            <div class="card-body py-2">
              <div class="d-flex justify-content-between align-items-center">
                <span>Subtotal:</span>
                <span>
                  @if ($item->product && $item->product->discount_price)
                    <span class="text-success">${{ number_format($item->product->discount_price, 2) }}</span>
                  @else
                    ${{ number_format($item->price, 2) }}
                  @endif
                </span>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <span>Shipping Fee:</span>
                <span>
                  @if ($order->shipping_fee > 0)
                    ${{ number_format($order->shipping_fee, 2) }}
                  @else
                    <span class="text-success">Free</span>
                  @endif
                </span>
              </div>
              <hr>
              <div class="d-flex justify-content-between align-items-center fw-bold">
                <span>Total:</span>
                <span>${{ number_format($order->total, 2) }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-flex flex-column flex-md-row gap-3 mb-5">
      <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary order-2 order-md-1">
        <i class="fas fa-arrow-left me-2"></i>Back to Orders
      </a>
      <button class="btn btn-primary order-1 order-md-2" onclick="window.print()">
        <i class="fas fa-print me-2"></i>Print Invoice
      </button>
    </div>
  </div>
@endsection

@section('styles')
  <style>
    .breadcrumb {
      -ms-overflow-style: none;
      /* IE and Edge */
      scrollbar-width: none;
      /* Firefox */
    }

    .breadcrumb::-webkit-scrollbar {
      display: none;
    }

    .order-items .card {
      transition: transform 0.2s ease;
    }

    .order-items .card:hover {
      transform: translateY(-2px);
    }

    @media (max-width: 767px) {
      .card-header h3 {
        font-size: 1.1rem;
      }

      .order-items h5 {
        font-size: 1.1rem;
      }

      .btn {
        width: 100%;
      }
    }
  </style>
@endsection
