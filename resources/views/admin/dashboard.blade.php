@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
  <div class="container-fluid">
    <!-- Stats Overview -->
    <div class="row mb-4">
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                  Total Orders</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalOrders }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-shopping-bag fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                  Total Revenue</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($totalRevenue, 2) }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                  Total Users</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-users fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                  Total Products</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProducts }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-box-open fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Order Status Overview -->
    <div class="row mb-4">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5 class="mb-0">Order Status Overview</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-2 mb-3">
                <a href="{{ route('admin.orders.index') }}" class="text-decoration-none">
                  <div class="card bg-light h-100">
                    <div class="card-body text-center">
                      <h6 class="card-title">All Orders</h6>
                      <h2 class="mb-0">{{ $totalOrders }}</h2>
                    </div>
                  </div>
                </a>
              </div>
              <div class="col-md-2 mb-3">
                <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="text-decoration-none">
                  <div class="card bg-warning text-dark h-100">
                    <div class="card-body text-center">
                      <h6 class="card-title">Pending</h6>
                      <h2 class="mb-0">{{ $pendingOrders }}</h2>
                    </div>
                  </div>
                </a>
              </div>
              <div class="col-md-2 mb-3">
                <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="text-decoration-none">
                  <div class="card bg-info text-white h-100">
                    <div class="card-body text-center">
                      <h6 class="card-title">Shipped</h6>
                      <h2 class="mb-0">{{ $processingOrders }}</h2>
                    </div>
                  </div>
                </a>
              </div>
              <div class="col-md-2 mb-3">
                <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}" class="text-decoration-none">
                  <div class="card bg-success text-white h-100">
                    <div class="card-body text-center">
                      <h6 class="card-title">Delivered</h6>
                      <h2 class="mb-0">{{ $completedOrders + $deliveredOrders }}</h2>
                    </div>
                  </div>
                </a>
              </div>
              <div class="col-md-2 mb-3">
                <a href="{{ route('admin.orders.index', ['status' => 'canceled']) }}" class="text-decoration-none">
                  <div class="card bg-danger text-white h-100">
                    <div class="card-body text-center">
                      <h6 class="card-title">Cancelled</h6>
                      <h2 class="mb-0">{{ $cancelledOrders }}</h2>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            <div class="mt-3">
              <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">View All Orders</a>
              <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="btn btn-outline-warning">View
                Pending Orders</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- Recent Orders -->
      <div class="col-md-8 mb-4">
        <div class="card">
          <div class="card-header">
            <h5 class="mb-0">Recent Orders</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($recentOrders as $order)
                    <tr>
                      <td>
                        <a href="{{ route('admin.orders.show', $order) }}">{{ $order->order_number }}</a>
                      </td>
                      <td>{{ $order->user->name }}</td>
                      <td>${{ number_format($order->total_price, 2) }}</td>
                      <td>
                        <span
                          class="badge bg-{{ $order->status == 'pending'
                              ? 'warning'
                              : ($order->status == 'processing'
                                  ? 'info'
                                  : ($order->status == 'shipped'
                                      ? 'primary'
                                      : ($order->status == 'delivered'
                                          ? 'success'
                                          : ($order->status == 'completed'
                                              ? 'success'
                                              : ($order->status == 'cancelled'
                                                  ? 'danger'
                                                  : 'secondary'))))) }}">
                          {{ ucfirst($order->status) }}
                        </span>
                      </td>
                      <td>{{ $order->created_at->format('M d, Y') }}</td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="5" class="text-center">No orders found</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
            <div class="mt-3">
              <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">View All Orders</a>
            </div>
          </div>
        </div>
        <div class="card mt-2">
          <div class="card-header">
            <h5 class="mb-0">Sales Per months</h5>
          </div>
          <div class="card-body">
            <p>Monthly sales data count: {{ count($monthlySales) }}</p>
            @if (count($monthlySales) > 0)
              <table class="table table-sm">
                <thead>
                  <tr>
                    <th>Month</th>
                    <th>Year</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($monthlySales as $sale)
                    <tr>
                      <td>{{ $sale->month }}</td>
                      <td>{{ $sale->year }}</td>
                      <td>${{ number_format($sale->total, 2) }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            @else
              <p class="text-danger">No sales data available. Make sure you have orders with non-cancelled status.</p>
            @endif
          </div>
        </div>
      </div>

      <!-- Low Stock Products -->
      <div class="col-md-4 mb-4">
        <div class="card ">
          <div class="card-header">
            <h5 class="mb-0">Low Stock Products</h5>
          </div>
          <div class="card-body">
            <div class="list-group">
              @forelse($lowStockProducts as $product)
                <a href="{{ route('admin.products.edit', $product) }}"
                  class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                  {{ $product->name }}
                  <span class="badge bg-danger rounded-pill">{{ $product->stock }} left</span>
                </a>
              @empty
                <div class="text-center py-3">
                  <p class="mb-0">No low stock products found</p>
                </div>
              @endforelse
            </div>
            <div class="mt-3">
              <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-primary">Manage Products</a>
            </div>
          </div>
        </div>
        {{-- Out of Stock Products --}}
        <div class="card mt-2">
          <div class="card-header">
            <h5 class="mb-0">Out of Stock Products</h5>
          </div>
          <div class="card-body">
            <div class="list-group">
              @forelse($outOfStockProducts as $product)
                <a href="{{ route('admin.products.edit', $product) }}"
                  class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                  {{ $product->name }}
                  <span class="badge bg-danger rounded-pill">Out of Stock</span>
                </a>
              @empty
                <div class="text-center py-3">
                  <p class="mb-0">No out of stock products found</p>
                </div>
              @endforelse
            </div>
            <div class="mt-3">
              <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-primary">Manage Products</a>
            </div>
          </div>
        </div>
        {{-- Most Purchased Products --}}
        <div class="card mt-2">
          <div class="card-header">
            <h5 class="mb-0">Most Purchased Products</h5>
          </div>
          <div class="card-body">
            <div class="list-group">
              @forelse($mostPurchasedProducts as $item)
                <a href="{{ route('admin.products.edit', $item->product) }}"
                  class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                  {{ $item->product->name }}
                  <span class="badge bg-success rounded-pill">{{ $item->total_quantity }} sold</span>
                </a>
              @empty
                <div class="text-center py-3">
                  <p class="mb-0">No product purchase data available</p>
                </div>
              @endforelse
            </div>
          </div>
        </div>
      </div>
    </div>
    {{-- <!-- Monthly Sales Chart -->
    @if (count($monthlySales) > 0)
      <div class="row">
        <div class="col-md-12 mb-4">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">Monthly Sales ({{ date('Y') }})</h5>
            </div>
            <div class="card-body">
              <div style="height: 300px;">
                <canvas id="monthlySalesChart" width="100%" height="100%"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif --}}
  </div>
@endsection

{{-- @push('styles')
  <style>

    .container-fluid {
      padding: 1.5rem;
    }

    /* Card Styles */
    .card {
      border: none;
      border-radius: 0.75rem;
      box-shadow: var(--shadow);
      transition: var(--transition);
      overflow: hidden;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card-header {
      background: linear-gradient(135deg, var(--primary) 0%, var(--info) 100%);
      color: var(--white);
      border-radius: 0.75rem 0.75rem 0 0;
      padding: 1rem 1.5rem;
      border-bottom: none;
    }

    .card-body {
      padding: 1.5rem;
    }

    /* Stats Cards */
    .card.border-left-primary {
      border-left: 5px solid var(--primary);
    }

    .card.border-left-success {
      border-left: 5px solid var(--success);
    }

    .card.border-left-info {
      border-left: 5px solid var(--info);
    }

    .card.border-left-warning {
      border-left: 5px solid var(--warning);
    }

    .card .text-xs {
      font-size: 0.85rem;
      letter-spacing: 0.05em;
    }

    .card .h5 {
      font-size: 1.5rem;
      font-weight: 700;
    }

    .card .fa-2x {
      opacity: 0.7;
      transition: var(--transition);
    }

    .card:hover .fa-2x {
      opacity: 1;
      transform: scale(1.1);
    }

    /* Order Status Cards */
    .card.bg-light {
      background: var(--white) !important;
      border: 1px solid #e5e7eb;
    }

    .card.bg-warning {
      background: linear-gradient(135deg, var(--warning) 0%, #d97706 100%) !important;
      color: var(--dark) !important;
    }

    .card.bg-info {
      background: linear-gradient(135deg, var(--info) 0%, #0ea5e9 100%) !important;
    }

    .card.bg-success {
      background: linear-gradient(135deg, var(--success) 0%, #16a34a 100%) !important;
    }

    .card.bg-danger {
      background: linear-gradient(135deg, var(--danger) 0%, #b91c1c 100%) !important;
    }

    .card-body.text-center h6 {
      font-size: 0.9rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
    }

    .card-body.text-center h2 {
      font-size: 1.75rem;
      font-weight: 700;
    }

    /* Buttons */
    .btn {
      border-radius: 0.5rem;
      padding: 0.5rem 1.25rem;
      font-weight: 500;
      transition: var(--transition);
    }

    .btn-primary {
      background: var(--primary);
      border-color: var(--primary);
    }

    .btn-primary:hover {
      background: #3b5bdb;
      border-color: #3b5bdb;
      transform: translateY(-2px);
    }

    .btn-outline-warning {
      border-color: var(--warning);
      color: var(--warning);
    }

    .btn-outline-warning:hover {
      background: var(--warning);
      color: var(--dark);
      transform: translateY(-2px);
    }

    .btn-sm {
      padding: 0.375rem 0.75rem;
      font-size: 0.875rem;
    }

    /* Tables */
    .table {
      border-radius: 0.5rem;
      overflow: hidden;
      background: var(--white);
    }

    .table thead {
      background: #f1f5f9;
      color: var(--dark);
    }

    .table th,
    .table td {
      padding: 1rem;
      vertical-align: middle;
      border-color: #e5e7eb;
    }

    .table tbody tr:hover {
      background: #f8fafc;
    }

    .badge {
      padding: 0.5rem 0.75rem;
      font-size: 0.85rem;
      border-radius: 0.25rem;
      font-weight: 500;
    }

    /* Chart Container */
    .chart-container {
      position: relative;
      height: 300px;
      width: 100%;
    }


  </style> --}}
{{-- @endpush --}}
