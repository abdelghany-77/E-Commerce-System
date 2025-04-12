<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
  public function index(Request $request)
  {
    // This indicates when admin last viewed the orders
    session(['last_orders_viewed_at' => now()->toDateTimeString()]);
    // Reset the notification counter for the current view
    View::share('newOrdersCount', 0);


    $query = Order::with('user');
    // Filter by status
    if ($request->has('status') && $request->status != 'all') {
      $query->where('status', $request->status);
    }
    // Filter by date range
    if ($request->has('from_date') && $request->from_date) {
      $query->whereDate('created_at', '>=', $request->from_date);
    }
    if ($request->has('to_date') && $request->to_date) {
      $query->whereDate('created_at', '<=', $request->to_date);
    }
    // Search by order number or customer name
    if ($request->has('search') && $request->search) {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        $q->where('order_number', 'like', "%{$search}%")
          ->orWhereHas('user', function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
          });
      });
    }

    // Sort orders
    $sortField = $request->get('sort', 'created_at');
    $sortDirection = $request->get('direction', 'desc');
    $query->orderBy($sortField, $sortDirection);

    $orders = $query->paginate(15)->withQueryString();
    // Get count of orders by status for dashboard statistics
    $orderCounts = [
      'all' => Order::count(),
      'pending' => Order::where('status', 'pending')->count(),
      'processing' => Order::where('status', 'processing')->count(),
      'completed' => Order::where('status', 'completed')->count(),
      'canceled' => Order::where('status', 'canceled')->count(),
    ];
    return view('admin.orders.index', compact('orders', 'orderCounts'));
  }


  public function show(Order $order)
  {
    $order->load(['user', 'items.product']);
    return view('admin.orders.show', compact('order'));
  }

  public function updateStatus(Request $request, Order $order)
  {
    $validated = $request->validate([
      'status' => 'required|in:pending,processing,completed,canceled',
    ]);

    $order->status = $validated['status'];
    $order->save();

    return redirect()->back()->with('success', 'Order status updated successfully.');
  }
}
