<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
  public function index(Request $request)
  {
    $query = Product::where('is_active', true);

    // Category filter
    if ($request->has('category')) {
      $category = Category::where('slug', $request->category)->firstOrFail();
      $query->whereHas('categories', function ($q) use ($category) {
        $q->where('categories.id', $category->id);
      });
    }

    // Search filter
    if ($request->has('search')) {
      $query->where(function ($q) use ($request) {
        $q->where('name', 'like', '%' . $request->search . '%')
          ->orWhere('description', 'like', '%' . $request->search . '%');
      });
    }

    // Apply sorting
    if ($request->has('sort')) {
      switch ($request->sort) {
        case 'price_asc':
          $query->orderBy('price', 'asc');
          break;
        case 'price_desc':
          $query->orderBy('price', 'desc');
          break;
        case 'newest':
          $query->latest();
          break;
        default:
          $query->latest();
          break;
      }
    } else {
      $query->latest();
    }

    $products = $query->paginate(12);

    // query to pagination links
    $products->appends($request->all());

    $categories = Category::all();

    return view('shop.index', compact('products', 'categories'));
  }

  public function show(Product $product)
  {
    if (!$product->is_active) {
      abort(404);
    }

    $relatedProducts = Product::where('id', '!=', $product->id)
      ->whereHas('categories', function ($query) use ($product) {
        $query->whereIn('categories.id', $product->categories->pluck('id'));
      })
      ->where('is_active', true)
      ->take(4)
      ->get();

    return view('shop.show', compact('product', 'relatedProducts'));
  }
}
