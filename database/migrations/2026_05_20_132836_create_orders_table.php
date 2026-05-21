<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
   public function up(): void
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('customer_name');
        $table->string('phone');
        $table->string('order_type')->default('pickup'); // pickup or dinein
        $table->string('method'); // Cash, GCash, PayMaya
        $table->text('notes')->nullable();
        $table->decimal('total_price', 10, 2)->default(0.00);
        $table->string('status')->default('Pending'); // Pending, Preparing, Completed
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}