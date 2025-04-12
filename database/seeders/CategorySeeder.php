<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
  public function run(): void
  {
    $categories = [
      'Electronics',
      'Clothing',
      'Home & Kitchen',
      'Books',
      'Sports & Outdoors',
      'Beauty & Personal Care',
      'Toys & Games',
      'Automotive',
    ];

    foreach ($categories as $category) {
      Category::create([
        'name' => $category,
        'slug' => Str::slug($category),
      ]);
    }

    $this->command->info('Categories created successfully.');
  }
}
