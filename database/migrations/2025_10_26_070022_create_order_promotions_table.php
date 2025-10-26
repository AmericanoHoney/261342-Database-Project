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
        Schema::create('order_promotions', function (Blueprint $table) {
            $table->foreignId('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            $table->foreignId('promotion_id')->references('promotion_id')->on('promotions')->onDelete('cascade');
            $table->primary(['order_id', 'promotion_id']);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_promotions');
    }
};
