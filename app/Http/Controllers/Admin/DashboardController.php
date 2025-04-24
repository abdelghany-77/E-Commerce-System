<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
  public function __construct()
  {
    $lastViewedAt = session('last_orders_viewed_at');
    if ($lastViewedAt) {
      $newOrdersCount = Order::where('status', 'pending')
        ->where('created_at', '>', $lastViewedAt)
        ->count();
    } else {
      // If never viewed, show all pending orders
      $newOrdersCount = Order::where('status', 'pending')->count();
    }
    View::share('newOrdersCount', $newOrdersCount);
  }
  public function index()
  {
    // Get total shipping fees not from database by logic
    // $totalShippingFees =20;

    // Get counts for dashboard cards
    $totalOrders = Order::count();
    $pendingOrders = Order::where('status', 'pending')->count();
    $processingOrders = Order::where('status', 'processing')->count();
    $shippedOrders = Order::where('status', 'shipped')->count();
    $deliveredOrders = Order::where('status', 'delivered')->count();
    $completedOrders = Order::where('status', 'completed')->count();
    $cancelledOrders = Order::where('status', 'canceled')->count();

    // Get total users and products
    $totalUsers = User::where('is_admin', 0)->count();
    $totalProducts = Product::count();

    // Get total sales
    $totalRevenue = Order::whereIn('status', ['completed', 'delivered'])
      ->sum('total_price');

    // Get recent orders
    $recentOrders = Order::with('user')
      ->orderBy('created_at', 'desc')
      ->take(5)
      ->get();

    // Get low stock products
    $lowStockProducts = Product::where('stock', '<=', 5)
      ->where('stock', '>', 0)
      ->orderBy('stock', 'asc')
      ->take(5)
      ->get();

    // Get out of stock products
    $outOfStockProducts = Product::where('stock', 0)
      ->orderBy('created_at', 'desc')
      ->take(5)
      ->get();

    // Get most bought products
    $mostPurchasedProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
      ->with('product')
      ->groupBy('product_id')
      ->orderByDesc('total_quantity')
      ->take(5)
      ->get();

    // Get monthly sales data for chart
    $monthlySales = Order::select(
      DB::raw('MONTH(created_at) as month'),
      DB::raw('YEAR(created_at) as year'),
      DB::raw('SUM(total_price) as total')
    )
      ->where('status', '!=', 'canceled')
      ->whereYear('created_at', date('Y'))
      ->groupBy('year', 'month')
      ->orderBy('year')
      ->orderBy('month')
      ->get();


    return view('admin.dashboard', compact(
      'totalOrders',
      'pendingOrders',
      'processingOrders',
      'shippedOrders',
      'deliveredOrders',
      'completedOrders',
      'cancelledOrders',
      'totalUsers',
      'totalRevenue',
      'totalProducts',
      'recentOrders',
      'lowStockProducts',
      'outOfStockProducts',
      'mostPurchasedProducts',
      'monthlySales',
      // 'totalShippingFees',
    ));
  }
}
