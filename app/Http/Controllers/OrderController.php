<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
  public function index()
  {
    $orders = Order::where('user_id', Auth::id())
      ->with('items')
      ->latest()
      ->paginate(6);

    foreach ($orders as $order) {
      if (is_null($order->shipping_fee)) {
        $subtotal = $order->items->sum(function ($item) {
          return $item->price * $item->quantity;
        });
        $order->shipping_fee = ($subtotal <= 1000 && $subtotal > 0) ? 20 : 0;
        $order->subtotal = $subtotal;
      } else {
        $order->subtotal = $order->total_price - $order->shipping_fee;
      }
    }

    return view('orders.index', compact('orders'));
  }

  public function show(Order $order)
  {
    if ($order->user_id !== Auth::id()) {
      abort(403);
    }
    $order->load('items.product');

    if (is_null($order->shipping_fee)) {
      // Calculate subtotal
      $subtotal = $order->items->sum(function ($item) {
        return $item->price * $item->quantity;
      });
      $order->shipping_fee = ($subtotal <= 1000 && $subtotal > 0) ? 20 : 0;
      $order->total = $subtotal + $order->shipping_fee;
      // $order->save();
    }
    return view('orders.show', compact('order'));
  }
}
