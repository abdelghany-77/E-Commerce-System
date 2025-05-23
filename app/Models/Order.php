<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'order_number',
    'total_price',
    'status',
    'shipping_address',
    'phone',
    'payment_method',
  ];

  protected $casts = [
    'total_price' => 'float',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function items()
  {
    return $this->hasMany(OrderItem::class);
  }
}
