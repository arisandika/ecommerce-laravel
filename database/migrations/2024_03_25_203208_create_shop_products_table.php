<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shop_products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('category_id');
            $table->string('name');
            $table->string('slug');
            $table->string('brand')->default('Unbranded')->nullable();
            $table->mediumText('short_description')->nullable();
            $table->longText('description')->nullable();

            $table->integer('regular_price');
            $table->integer('sale_price')->default(0);
            $table->integer('quantity')->default(0);
            $table->integer('weight');

            $table->tinyInteger('trending')->default(0)->comment('0=non trending, 1=trending');
            $table->tinyInteger('featured')->default(0)->comment('0=not featured, 1=featured');
            $table->tinyInteger('visibility')->default(0)->comment('0=publish, 1=private');

            $table->string('meta_title')->nullable();
            $table->mediumText('meta_keyword')->nullable();
            $table->longText('meta_description')->nullable();

            $table->foreign('category_id')->references('id')->on('shop_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_products');
    }
};
