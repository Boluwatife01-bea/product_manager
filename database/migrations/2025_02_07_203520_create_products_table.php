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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Product name
            $table->text('description')->nullable(); // Product description (optional)
            $table->decimal('price', 8, 2); // Product price
            $table->integer('stock'); // Product stock quantity
            $table->string('image')->nullable(); // Product image path
            $table->timestamps();
            $table->softDeletes(); // Enables "Trash" functionality
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
