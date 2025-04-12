<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
  public function index()
  {
    $products = Product::latest()->paginate(10);
    return view('admin.products.index', compact('products'));
  }

  public function create()
  {
    $categories = Category::all();
    return view('admin.products.create', compact('categories'));
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'required',
      'price' => 'required|numeric|min:0',
      'stock' => 'required|integer|min:0',
      'categories' => 'array',
      'image' => 'nullable|image|max:2048',
      'is_active' => 'boolean',
    ]);

    $product = new Product();
    $product->name = $validated['name'];
    $product->description = $validated['description'];
    $product->price = $validated['price'];
    $product->stock = $validated['stock'];
    $product->is_active = $request->has('is_active');

    if ($request->hasFile('image')) {
      $path = $request->file('image')->store('products', 'public');
      $product->image = $path;
    }

    $product->save();

    if ($request->has('categories')) {
      $product->categories()->attach($request->categories);
    }

    return redirect()->route('admin.products.index')
      ->with('success', 'Product created successfully.');
  }

  public function edit(Product $product)
  {
    $categories = Category::all();
    $selectedCategories = $product->categories->pluck('id')->toArray();
    return view('admin.products.edit', compact('product', 'categories', 'selectedCategories'));
  }

  public function update(Request $request, Product $product)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'required',
      'price' => 'required|numeric|min:0',
      'stock' => 'required|integer|min:0',
      'categories' => 'array',
      'image' => 'nullable|image|max:2048',
      'is_active' => 'boolean',
    ]);

    $product->name = $validated['name'];
    $product->description = $validated['description'];
    $product->price = $validated['price'];
    $product->stock = $validated['stock'];
    $product->is_active = $request->has('is_active');

    if ($request->hasFile('image')) {
      // Delete old image
      if ($product->image) {
        Storage::disk('public')->delete($product->image);
      }

      $path = $request->file('image')->store('products', 'public');
      $product->image = $path;
    }

    $product->save();

    // Update categories
    if ($request->has('categories')) {
      $product->categories()->sync($request->categories);
    } else {
      $product->categories()->detach();
    }

    return redirect()->route('admin.products.index')
      ->with('success', 'Product updated successfully.');
  }

  public function destroy(Product $product)
  {
    // Delete image
    if ($product->image) {
      Storage::disk('public')->delete($product->image);
    }

    $product->delete();

    return redirect()->route('admin.products.index')
      ->with('success', 'Product deleted successfully.');
  }
}
