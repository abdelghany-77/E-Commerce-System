@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
  <div class="container py-4">
    <!-- Header Section -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
      <h2 class="mb-3 mb-md-0 fw-bold">Order History</h2>
      <div class="d-flex flex-column flex-md-row gap-2 w-100 w-md-auto">
        <input type="text" id="orderSearch" class="form-control rounded-pill shadow-sm" placeholder="Search by Order #"
          aria-label="Search orders by order number">
        <a href="{{ route('shop.index') }}" class="btn btn-outline-primary rounded-pill w-100 w-md-auto">
          <i class="fas fa-shopping-bag me-2"></i>
          <span class="d-none d-md-inline">Continue Shopping</span>
          <span class="d-md-none">Shop More</span>
        </a>
      </div>
    </div>

    <!-- Summary Card -->
    @if ($orders->isNotEmpty())
      <div class="card shadow-sm mb-4">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center">
          <div class="mb-3 mb-md-0">
            <h5 class="mb-1">Total Orders</h5>
            <p class="text-muted mb-0">{{ $orders->total() }}</p>
          </div>
          <div class="mb-3 mb-md-0">
            <h5 class="mb-1">Total Spent</h5>
            <p class="text-muted mb-0">${{ number_format($orders->sum('subtotal') + $orders->sum('shipping_fee'), 2) }}
            </p>
          </div>
        </div>
      </div>
    @endif

    @if ($orders->isEmpty())
      <!-- Empty State -->
      <div class="empty-state text-center py-5">
        <div class="empty-state-icon mb-4">
          <i class="fas fa-box-open fa-4x text-muted animate__animated animate__fadeIn"></i>
        </div>
        <h3 class="mb-3 fw-bold">No Orders Found</h3>
        <p class="text-muted mb-4">Start exploring our products and place your first order!</p>
        <a href="{{ route('shop.index') }}" class="btn btn-primary px-5 rounded-pill shadow-sm">
          Start Shopping <i class="fas fa-arrow-right ms-2"></i>
        </a>
      </div>
    @else
      <!-- Mobile View -->
      <div class="d-block d-md-none">
        @foreach ($orders as $order)
          <div class="card shadow-sm mb-3 order-card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="text-muted small">Order #</div>
                <div class="fw-bold">{{ $order->order_number }}</div>
              </div>

              <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="text-muted small">Date</div>
                <div>{{ $order->created_at->format('d M Y') }}</div>
              </div>

              <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="text-muted small">Status</div>
                <div>
                  @if ($order->status == 'pending')
                    <span class="badge bg-warning text-dark">Pending</span>
                  @elseif($order->status == 'processing')
                    <span class="badge bg-info">Processing</span>
                  @elseif($order->status == 'completed')
                    <span class="badge bg-success">Completed</span>
                  @elseif($order->status == 'canceled')
                    <span class="badge bg-danger">Canceled</span>
                  @endif
                </div>
              </div>

              <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="text-muted small">Items</div>
                <div>{{ $order->items->sum('quantity') }}</div>
              </div>

              <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="text-muted small">Subtotal</div>
                <div>${{ number_format($order->subtotal, 2) }}</div>
              </div>

              <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="text-muted small">Shipping</div>
                <div>
                  @if ($order->shipping_fee > 0)
                    ${{ number_format($order->shipping_fee, 2) }}
                  @else
                    <span class="text-success">Free</span>
                  @endif
                </div>
              </div>

              <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="text-muted small">Total</div>
                <div class="fw-bold">${{ number_format($order->subtotal + $order->shipping_fee, 2) }}</div>
              </div>

              <div class="d-flex gap-2">
                <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-primary w-100 rounded-pill">
                  View Details <i class="fas fa-chevron-right ms-2"></i>
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <!-- Desktop View -->
      <div class="d-none d-md-block card shadow-sm">
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead class="bg-light">
                <tr>
                  <th scope="col">Order #</th>
                  <th scope="col">Date</th>
                  <th scope="col">Status</th>
                  <th scope="col">Items</th>
                  <th scope="col" class="text-end">Subtotal</th>
                  <th scope="col" class="text-end">Shipping</th>
                  <th scope="col" class="text-end">Total</th>
                  <th scope="col" class="text-end">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($orders as $order)
                  <tr class="order-row">
                    <td class="fw-bold">{{ $order->order_number }}</td>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                    <td>
                      @if ($order->status == 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                      @elseif($order->status == 'processing')
                        <span class="badge bg-info">Processing</span>
                      @elseif($order->status == 'completed')
                        <span class="badge bg-success">Completed</span>
                      @elseif($order->status == 'canceled')
                        <span class="badge bg-danger">Canceled</span>
                      @endif
                    </td>
                    <td>{{ $order->items->sum('quantity') }}</td>
                    <td class="text-end">${{ number_format($order->subtotal, 2) }}</td>
                    <td class="text-end">
                      @if ($order->shipping_fee > 0)
                        ${{ number_format($order->shipping_fee, 2) }}
                      @else
                        <span class="text-success">Free</span>
                      @endif
                    </td>
                    <td class="text-end">${{ number_format($order->subtotal + $order->shipping_fee, 2) }}</td>
                    <td class="text-end">
                      <a href="{{ route('orders.show', $order) }}"
                        class="btn btn-sm btn-outline-primary rounded-pill me-1"
                        aria-label="View order details for order {{ $order->order_number }}">
                        Details <i class="fas fa-chevron-right ms-2"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    @endif

    <!-- Pagination -->
    @if ($orders->isNotEmpty())
      <div class="d-flex justify-content-center mt-4">
        {{ $orders->appends(request()->query())->links('pagination.bootstrap-5') }}
      </div>
    @endif
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const searchInput = document.getElementById('orderSearch');
      const orderCards = document.querySelectorAll('.order-card');
      const orderRows = document.querySelectorAll('.order-row');

      searchInput.addEventListener('input', () => {
        const searchTerm = searchInput.value.toLowerCase();

        // Mobile view filtering
        orderCards.forEach(card => {
          const orderNumber = card.querySelector('.fw-bold').textContent.toLowerCase();
          card.style.display = orderNumber.includes(searchTerm) ? '' : 'none';
        });

        // Desktop view filtering
        orderRows.forEach(row => {
          const orderNumber = row.querySelector('.fw-bold').textContent.toLowerCase();
          row.style.display = orderNumber.includes(searchTerm) ? '' : 'none';
        });
      });
    });
  </script>
@endsection
