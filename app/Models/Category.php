<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'slug',
  ];

  public function products()
  {
    return $this->belongsToMany(Product::class);
  }

  public function getRouteKeyName()
  {
    return 'slug';
  }
}
