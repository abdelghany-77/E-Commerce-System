@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="mb-0">Orders Management</h2>
    </div>

    <!-- Status Cards-->
    <div class="row mb-4">
      <div class="col-md-2 mb-3">
        <a href="{{ route('admin.orders.index', ['status' => 'all']) }}" class="text-decoration-none">
          <div class="card bg-light h-100">
            <div class="card-body text-center">
              <h6 class="card-title">All Orders</h6>
              <h2 class="mb-0">{{ $orderCounts['all'] }}</h2>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md-2 mb-3">
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="text-decoration-none">
          <div class="card bg-warning text-dark h-100">
            <div class="card-body text-center">
              <h6 class="card-title">Pending</h6>
              <h2 class="mb-0">{{ $orderCounts['pending'] }}</h2>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md-2 mb-3">
        <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="text-decoration-none">
          <div class="card bg-info text-white h-100">
            <div class="card-body text-center">
              <h6 class="card-title">Shipped</h6>
              <h2 class="mb-0">{{ $orderCounts['processing'] }}</h2>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md-2 mb-3">
        <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}" class="text-decoration-none">
          <div class="card bg-success text-white h-100">
            <div class="card-body text-center">
              <h6 class="card-title">Delivered</h6>
              <h2 class="mb-0">{{ $orderCounts['completed'] }}</h2>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md-2 mb-3">
        <a href="{{ route('admin.orders.index', ['status' => 'canceled']) }}" class="text-decoration-none">
          <div class="card bg-danger text-white h-100">
            <div class="card-body text-center">
              <h6 class="card-title">Cancelled</h6>
              <h2 class="mb-0">{{ $orderCounts['canceled'] }}</h2>
            </div>
          </div>
        </a>
      </div>
    </div>

    <!-- Advanced Filter Form -->
    <div class="card mb-4">
      <div class="card-header bg-light">
        <h5 class="mb-0">Filter Orders</h5>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-3">
          <div class="col-md-3">
            <label for="from_date" class="form-label">From Date</label>
            <input type="date" class="form-control" id="from_date" name="from_date"
              value="{{ request('from_date') }}">
          </div>
          <div class="col-md-3">
            <label for="to_date" class="form-label">To Date</label>
            <input type="date" class="form-control" id="to_date" name="to_date" value="{{ request('to_date') }}">
          </div>
          <div class="col-md-3">
            <label for="search" class="form-label">Search</label>
            <input type="text" class="form-control" id="search" name="search" placeholder="Order # or Customer"
              value="{{ request('search') }}">
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-primary">Apply Filters</button>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Clear Filters</a>
          </div>
        </form>
      </div>
    </div>

    <!-- Orders Table -->
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Subtotal</th>
                <th>Shipping</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($orders as $order)
                <tr>
                  <td>{{ $order->order_number }}</td>
                  <td>{{ $order->user->name }}</td>
                  <td>${{ number_format($order->subtotal, 2) }}</td>
                  <td>
                    @if ($order->shipping_fee > 0)
                      ${{ number_format($order->shipping_fee, 2) }}
                    @else
                      <span class="text-success">Free</span>
                    @endif
                  </td>
                  <td>${{ number_format($order->total_price + $order->shipping_fee, 2) }}</td>
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
                  <td>
                    <div class="btn-group">
                      <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">View</a>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center">No orders found</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
          {{ $orders->links('pagination.bootstrap-5') }}
        </div>
      </div>
    </div>
  </div>
@endsection
