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
        Schema::create('shop_product_sizes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('product_id');
            $table->string('size_id')->nullable();
            $table->integer('quantity');
            $table->integer('size_price')->default(0);

            $table->foreign('product_id')->references('id')->on('shop_products')->onDelete('cascade');
            $table->foreign('size_id')->references('id')->on('shop_sizes')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_product_sizes');
    }
};
