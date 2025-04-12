<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
  public function index()
  {
    $orders = Order::where('user_id', Auth::id())->latest()->paginate(6);
    return view('orders.index', compact('orders'));
  }

  public function show(Order $order)
  {
    // Ensure the order belongs to the logged-in user
    if ($order->user_id !== Auth::id()) {
      abort(403);
    }

    $order->load('items.product');
    return view('orders.show', compact('order'));
  }
}
