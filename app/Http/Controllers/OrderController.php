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
      ->with('items.product')
      ->latest()
      ->paginate(6);

    foreach ($orders as $order) {
      if (is_null($order->shipping_fee)) {
        $subtotal = $order->items->sum(function ($item) {
          // Check if product exists and has discount price
          if (isset($item->product) && $item->product->discount_price) {
            return $item->product->discount_price * $item->quantity;
          }
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
      // Calculate subtotal considering discount prices
      $subtotal = $order->items->sum(function ($item) {
        // If the order item already has the correct price (which should include any discount)
        // then just use that price, otherwise check product for discount price
        if (isset($item->product) && $item->product->discount_price) {
          return $item->product->discount_price * $item->quantity;
        }
        return $item->price * $item->quantity;
      });

      $order->shipping_fee = ($subtotal <= 1000 && $subtotal > 0) ? 20 : 0;
      $order->total = $subtotal + $order->shipping_fee;
    }
    return view('orders.show', compact('order'));
  }
}
