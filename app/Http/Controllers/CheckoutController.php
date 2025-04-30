<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
  public function index()
  {
    $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();

    if ($cartItems->isEmpty()) {
      return redirect()->route('shop.index')->with('error', 'Your cart is empty.');
    }

    $total = $cartItems->sum(function ($item) {
      $price = $item->product->discount_price ?? $item->product->price;
      return $price * $item->quantity;
    });
    $shippingFee = ($total <= 1000 && $total > 0) ? 20 : 0;
    $grandTotal = $total + $shippingFee;

    return view('checkout.index', compact('cartItems', 'total', 'shippingFee', 'grandTotal'));
  }

  public function process(Request $request)
  {
    $validated = $request->validate([
      'shipping_address' => 'required|string',
      'payment_method' => 'required|in:cash_on_delivery',
    ]);

    $user = Auth::user();
    $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();

    if ($cartItems->isEmpty()) {
      return redirect()->route('shop.index')->with('error', 'Your cart is empty.');
    }

    $total = $cartItems->sum(function ($item) {
      return $item->product->price * $item->quantity;
    });

    DB::beginTransaction();

    try {
      // Create order
      $order = new Order();
      $order->user_id = $user->id;
      $order->order_number = 'ORD-' . strtoupper(Str::random(10));
      $order->total_price = $total;
      $order->status = 'pending';
      $order->shipping_address = $validated['shipping_address'];
      $order->payment_method = $validated['payment_method'];
      $order->save();

      // Create order items and update stock
      foreach ($cartItems as $item) {
        $product = $item->product;

        // Check if still in stock
        if ($product->stock < $item->quantity) {
          throw new \Exception("Not enough stock for {$product->name}");
        }

        // Create order item
        OrderItem::create([
          'order_id' => $order->id,
          'product_id' => $product->id,
          'quantity' => $item->quantity,
          'price' => $product->price,
        ]);

        // Reduce stock
        $product->stock -= $item->quantity;
        $product->save();
      }
      //This will make the new order show up as a notification
      Session::forget('admin_orders_last_checked');
      // Clear cart
      CartItem::where('user_id', Auth::id())->delete();
      DB::commit();
      return redirect()->route('orders.show', $order)
        ->with('success', 'Order placed successfully!');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('error', $e->getMessage());
    }
  }
}
