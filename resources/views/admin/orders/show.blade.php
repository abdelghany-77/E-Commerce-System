@extends('layouts.admin')

@section('title', 'Order Details')

@section('breadcrumb')
  <li class="breadcrumb-item">
    <a href="{{ route('admin.orders.index') }}" class="text-muted">Orders</a>
  </li>
  <li class="breadcrumb-item active text-primary">Order Details</li>
@endsection

@section('content')
  <div class="card border-0 shadow-lg">
    <div class="card-header">
      <h5 class="mb-0">Order # {{ $order->order_number }}</h5>
      <div class="text-muted small">
        <i class="fas fa-calendar-alt me-2"></i>
        {{ $order->created_at->format('F j, Y') }}
        <span class="mx-2">|</span>
        <i class="fas fa-clock me-2"></i>
        {{ $order->created_at->format('g:i A') }}
        <span class="mx-2">|</span>
        <span
          class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'canceled' ? 'danger' : 'warning') }}">
          {{ ucfirst($order->status) }}
        </span>
      </div>
    </div>
    <div class="card-body">
      <!-- Order Overview -->
      <div class="row g-4 mb-5">
        <!-- Customer Info -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-dark">
              <h6 class="mb-0"><i class="fas fa-user me-2"></i>Customer Information</h6>
            </div>
            <div class="card-body small">
              <p class="mb-2"><strong>Name:</strong> {{ $order->user->name }}</p>
              <p class="mb-2"><strong>Email:</strong> {{ $order->user->email }}</p>
              <p class="mb-2"><strong>Phone:</strong> {{ $order->user->phone ?? 'N/A' }}</p>
              <p class="mb-0"><strong>Address:</strong> {{ $order->user->address ?? 'N/A' }}</p>
            </div>
          </div>
        </div>

        <!-- Order Details -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-dark">
              <h6 class="mb-0"><i class="fas fa-receipt me-2"></i>Order Details</h6>
            </div>
            <div class="card-body small">
              <p class="mb-2"><strong>Payment Method:</strong>
                {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
              <p class="mb-2"><strong>Total Amount:</strong>
                ${{ number_format($order->total_price + $order->shipping_fee, 2) }}</p>
              <p class="mb-0"><strong>Items:</strong>
                {{ $order->items->sum('quantity') }}</p>
            </div>
          </div>
        </div>

        <!-- Status Update -->
        <div class="col-md-12 col-lg-4">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-dark">
              <h6 class="mb-0"><i class="fas fa-sync-alt me-2"></i>Update Status</h6>
            </div>
            <div class="card-body">
              <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="input-group">
                  <select name="status" class="form-select border-end-0">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Shipped</option>
                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Delivered</option>
                    <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Cancelled</option>
                  </select>
                  <button type="submit" class="btn btn-primary">
                    Update <i class="fas fa-check"></i>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Shipping Address -->
      <div class="card border-0 shadow-sm mb-5">
        <div class="card-header bg-dark">
          <h6 class="mb-0"><i class="fas fa-truck me-2"></i>Shipping Address</h6>
        </div>
        <div class="card-body">
          <pre class="mb-0 font-sans-serif">{{ $order->shipping_address }}</pre>
        </div>
      </div>

      <!-- Order Items -->
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-dark">
          <h6 class="mb-0"><i class="fas fa-boxes me-2"></i>Order Items</h6>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="bg-light">
                <tr>
                  <th style="width: 60px"></th>
                  <th>Product</th>
                  <th class="text-end">Price</th>
                  <th class="text-center">Qty</th>
                  <th class="text-end">Subtotal</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($order->items as $item)
                  <tr>
                    <td>
                      @if ($item->product && $item->product->image)
                        <img src="{{ asset('storage/' . $item->product->image) }}" class="rounded-2 border"
                          alt="{{ $item->product->name }}" style="width: 50px; height: 50px; object-fit: contain;">
                      @else
                        <div class="bg-light rounded-2 d-flex align-items-center justify-content-center"
                          style="width: 50px; height: 50px;">
                          <i class="fas fa-image fa-lg text-muted"></i>
                        </div>
                      @endif
                    </td>
                    <td>
                      @if ($item->product)
                        <a href="{{ route('admin.products.edit', $item->product) }}" class="text-decoration-none">
                          {{ $item->product->name }}
                        </a>
                      @else
                        <span class="text-muted">Product Unavailable</span>
                      @endif
                    </td>
                    <td class="text-end">${{ number_format($item->price, 2) }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-end fw-bold">${{ number_format($item->price * $item->quantity, 2) }}</td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot class="bg-light">
                <tr>
                  <td colspan="4" class="text-end fw-bold">Subtotal:</td>
                  <td class="text-end fw-bold">
                    ${{ number_format(isset($order->subtotal) ? $order->subtotal : $order->total_price - $order->shipping_fee, 2) }}
                  </td>
                </tr>
                <tr>
                  <td colspan="4" class="text-end fw-bold">Shipping Fee:</td>
                  <td class="text-end fw-bold">
                    @if ($order->shipping_fee > 0)
                      ${{ number_format($order->shipping_fee, 2) }}
                    @else
                      <span class="text-success">Free</span>
                    @endif
                  </td>
                </tr>
                <tr>
                  <td colspan="4" class="text-end fw-bold">Total:</td>
                  <td class="text-end fw-bold">${{ number_format($order->total_price + $order->shipping_fee, 2) }}</td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>

      <!-- Back Button -->
      <div class="mt-4">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
          <i class="fas fa-arrow-left me-2"></i>Back to Orders
        </a>
      </div>
    </div>
  </div>
@endsection
