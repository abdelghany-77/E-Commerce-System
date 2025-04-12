<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\View;

class AdminOrderNotificationsMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next)
  {
    // Only process for admin routes
    if (str_starts_with($request->route()->getName(), 'admin.')) {
      // Get the last time admin viewed orders
      $lastOrderCheck = session('admin_last_order_check');

      // Count new orders (pending orders created after the last check)
      $query = Order::where('status', 'pending');

      if ($lastOrderCheck) {
        $query->where('created_at', '>', $lastOrderCheck);
      }

      $newOrdersCount = $query->count();

      // When the admin views the orders page, reset the counter
      if ($request->route()->getName() === 'admin.orders.index') {
        session(['admin_last_order_check' => now()]);
        $newOrdersCount = 0;
      }
      // Share the count with all views
      View::share('newOrdersCount', $newOrdersCount);
    }
    return $next($request);
  }
}
