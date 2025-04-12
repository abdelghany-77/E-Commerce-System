<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'description',
    'price',
    'stock',
    'image',
    'is_active',
  ];

  protected $casts = [
    'price' => 'float',
    'is_active' => 'boolean',
  ];

  public function categories()
  {
    return $this->belongsToMany(Category::class);
  }
}
