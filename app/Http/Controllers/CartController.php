<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
  public function index()
  {
    $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();
    $total = $cartItems->sum(function ($item) {
      return $item->product->price * $item->quantity;
    });

    $shippingFee = ($total <= 1000 && $total > 0) ? 20 : 0;
    $grandTotal = $total + $shippingFee;

    return view('cart.index', compact('cartItems', 'total', 'shippingFee', 'grandTotal'));
  }

  public function add(Request $request)
  {
    $validated = $request->validate([
      'product_id' => 'required|exists:products,id',
      'quantity' => 'required|integer|min:1',
    ]);

    $product = Product::findOrFail($validated['product_id']);

    // Check if product is in stock
    if ($product->stock < $validated['quantity']) {
      return redirect()->back()->with('error', 'Not enough stock available.');
    }

    // Check if product is already in cart
    $existingItem = CartItem::where('user_id', Auth::id())
      ->where('product_id', $validated['product_id'])
      ->first();

    if ($existingItem) {
      $existingItem->quantity += $validated['quantity'];
      $existingItem->save();
    } else {
      CartItem::create([
        'user_id' => Auth::id(),
        'product_id' => $validated['product_id'],
        'quantity' => $validated['quantity'],
      ]);
    }

    return redirect()->back()->with('success', 'Product added to cart.');
  }

  public function update(Request $request, CartItem $cartItem)
  {
    $validated = $request->validate([
      'quantity' => 'required|integer|min:1',
    ]);

    // Check if product is in stock
    if ($cartItem->product->stock < $validated['quantity']) {
      return redirect()->back()->with('error', 'Not enough stock available.');
    }

    $cartItem->quantity = $validated['quantity'];
    $cartItem->save();

    return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
  }

  public function remove(CartItem $cartItem)
  {
    $cartItem->delete();
    return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
  }

}
