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
        Schema::create('shop_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('user_id');
            $table->string('tracking_no');
            $table->string('fullname');
            $table->string('email');
            $table->string('phone');
            $table->string('postcode');
            $table->mediumText('address');
            $table->bigInteger('subtotal_price');
            $table->bigInteger('shipping_cost');
            $table->bigInteger('total_price');
            $table->string('status_order');
            $table->string('payment_method');
            $table->string('snap_token')->nullable();
            $table->string('payment_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_orders');
    }
};
