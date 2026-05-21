<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('order_items', function (Blueprint $table) {
        $table->id();
        // Creates the link to the orders table. If an order is deleted, its items are too.
        $table->foreignId('order_id')->constrained()->onDelete('cascade');
        $table->string('product_name');
        $table->integer('quantity');
        $table->decimal('price', 10, 2);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
