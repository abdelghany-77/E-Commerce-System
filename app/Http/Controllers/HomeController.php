<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function index()
  {
    // Get products with discount (flash sales)
    $flashSales = Product::whereNotNull('discount_price')
      ->whereColumn('discount_price', '<', 'price')
      ->orderByDesc('updated_at')
      ->take(4)
      ->get();
    // Get products with featured status
    $featuredProducts = Product::where('is_active', true)
      ->inRandomOrder()
      ->take(8)
      ->get();
    // Get products with price > 1000 (free shipping)
    $freeShippingProducts = Product::where(function ($q) {
      $q->where('discount_price', '>', 1000)
        ->orWhere(function ($q2) {
          $q2->whereNull('discount_price')
            ->where('price', '>', 1000);
        });
    })
      ->orderByDesc('price')
      ->take(4)
      ->get();
    $categories = Category::with(['products' => function ($query) {
      $query->where('is_active', true)->latest()->take(4);
    }])->get();
    return view('home.index', compact('featuredProducts', 'categories', 'flashSales', 'freeShippingProducts'));
  }
}
