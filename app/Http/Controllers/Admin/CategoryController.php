<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
  public function index()
  {
    $categories = Category::latest()->paginate(10);
    return view('admin.categories.index', compact('categories'));
  }

  public function create()
  {
    return view('admin.categories.create');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255|unique:categories',
      'slug' => 'nullable|string|max:255|unique:categories',
    ]);

    $category = new Category();
    $category->name = $validated['name'];
    $category->slug = $validated['slug'] ?? Str::slug($validated['name']);
    $category->save();

    return redirect()->route('admin.categories.index')
      ->with('success', 'Category created successfully.');
  }

  public function edit(Category $category)
  {
    return view('admin.categories.edit', compact('category'));
  }

  public function update(Request $request, Category $category)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
      'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
    ]);

    $category->name = $validated['name'];
    $category->slug = $validated['slug'] ?? Str::slug($validated['name']);
    $category->save();

    return redirect()->route('admin.categories.index')
      ->with('success', 'Category updated successfully.');
  }

  public function destroy(Category $category)
  {
    // Check if category has products
    if ($category->products()->count() > 0) {
      return redirect()->route('admin.categories.index')
        ->with('error', 'Cannot delete category because it has associated products.');
    }

    $category->delete();

    return redirect()->route('admin.categories.index')
      ->with('success', 'Category deleted successfully.');
  }
}
