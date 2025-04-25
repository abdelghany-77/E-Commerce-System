<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
  public function run(): void
  {
    $products = [
      // Electronics
      [
        'name' => 'Smartphone X Pro',
        'description' => 'Latest smartphone with high-resolution camera, fast processor, and long battery life.',
        'price' => 999.99,
        'discount_price' => 899.99,
        'stock' => 50,
        'is_active' => true,
        'categories' => ['Electronics'],
      ],
      [
        'name' => 'Laptop Ultra',
        'description' => 'Thin and lightweight laptop with powerful performance for professionals.',
        'price' => 1299.99,
        'discount_price' => 1199.99,
        'stock' => 30,
        'is_active' => true,
        'categories' => ['Electronics'],
      ],
      [
        'name' => 'Wireless Earbuds',
        'description' => 'True wireless earbuds with noise cancellation and crystal clear sound.',
        'price' => 149.99,
        'stock' => 100,
        'is_active' => true,
        'categories' => ['Electronics'],
      ],

      // Clothing
      [
        'name' => 'Men\'s Classic T-Shirt',
        'description' => 'Comfortable cotton t-shirt for everyday wear. Available in multiple colors.',
        'price' => 24.99,
        'stock' => 200,
        'is_active' => true,
        'categories' => ['Clothing'],
      ],
      [
        'name' => 'Women\'s Casual Jeans',
        'description' => 'Stylish and comfortable jeans for women, perfect for casual occasions.',
        'price' => 59.99,
        'stock' => 150,
        'is_active' => true,
        'categories' => ['Clothing'],
      ],

      // Home & Kitchen
      [
        'name' => 'Coffee Maker Deluxe',
        'description' => 'Programmable coffee maker with built-in grinder for the perfect cup of coffee.',
        'price' => 129.99,
        'stock' => 40,
        'is_active' => true,
        'categories' => ['Home & Kitchen'],
      ],
      [
        'name' => 'Non-stick Cookware Set',
        'description' => '10-piece non-stick cookware set for all your cooking needs.',
        'price' => 89.99,
        'discount_price' => 79.99,
        'stock' => 30,
        'is_active' => true,
        'categories' => ['Home & Kitchen'],
      ],

      // Books
      [
        'name' => 'The Great Adventure',
        'description' => 'Bestselling novel about an epic journey across continents.',
        'price' => 19.99,
        'discount_price' => 14.99,
        'stock' => 100,
        'is_active' => true,
        'categories' => ['Books'],
      ],
      [
        'name' => 'Web Development Mastery',
        'description' => 'Comprehensive guide to modern web development techniques and frameworks.',
        'price' => 34.99,
        'stock' => 75,
        'is_active' => true,
        'categories' => ['Books', 'Electronics'],
      ],

      // Sports & Outdoors
      [
        'name' => 'Yoga Mat Premium',
        'description' => 'Thick, non-slip yoga mat for comfortable practice.',
        'price' => 29.99,
        'stock' => 120,
        'is_active' => true,
        'categories' => ['Sports & Outdoors'],
      ],
      [
        'name' => 'Camping Tent 4-Person',
        'description' => 'Waterproof camping tent that comfortably fits 4 people.',
        'price' => 149.99,
        'discount_price' => 129.99,
        'stock' => 25,
        'is_active' => true,
        'categories' => ['Sports & Outdoors'],
      ],

      // Beauty & Personal Care
      [
        'name' => 'Luxury Perfume Set',
        'description' => 'Gift set containing 3 premium fragrances for all occasions.',
        'price' => 79.99,
        'stock' => 50,
        'is_active' => true,
        'categories' => ['Beauty & Personal Care'],
      ],
      //Toys & Games category
      [
        'name' => 'Remote Control Car',
        'description' => 'Fast and durable remote control car for kids and adults.',
        'price' => 49.99,
        'stock' => 60,
        'is_active' => true,
        'categories' => ['Toys & Games'],
      ],
      [
        'name' => 'Puzzle Game Set',
        'description' => 'Challenging puzzle game set for family fun.',
        'price' => 19.99,
        'stock' => 80,
        'is_active' => true,
        'categories' => ['Toys & Games'],
      ],
    ];

    foreach ($products as $productData) {
      $categoryNames = $productData['categories'];
      unset($productData['categories']);

      $product = Product::create($productData);

      // Attach categories
      foreach ($categoryNames as $categoryName) {
        $category = Category::where('name', $categoryName)->first();
        if ($category) {
          $product->categories()->attach($category->id);
        }
      }
    }

    $this->command->info('Products created successfully.');
  }
}
