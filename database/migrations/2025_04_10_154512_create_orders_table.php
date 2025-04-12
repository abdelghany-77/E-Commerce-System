<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('orders', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained();
      $table->string('order_number')->unique();
      $table->decimal('total_price', 10, 2);
      $table->enum('status', ['pending', 'processing', 'completed', 'canceled'])->default('pending');
      $table->text('shipping_address');
      $table->string('phone')->nullable();
      $table->string('payment_method');
      $table->timestamps();
    });

    Schema::create('order_items', function (Blueprint $table) {
      $table->id();
      $table->foreignId('order_id')->constrained()->onDelete('cascade');
      $table->foreignId('product_id')->constrained();
      $table->integer('quantity');
      $table->decimal('price', 10, 2);
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('order_items');
    Schema::dropIfExists('orders');
  }
};
