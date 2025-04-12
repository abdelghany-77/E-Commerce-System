<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function index()
  {
    $featuredProducts = Product::where('is_active', true)
      ->inRandomOrder()
      ->take(8)
      ->get();

    $categories = Category::with(['products' => function ($query) {
      $query->where('is_active', true)->latest()->take(4);
    }])->get();
    return view('home.index', compact('featuredProducts','categories'));
  }
}
