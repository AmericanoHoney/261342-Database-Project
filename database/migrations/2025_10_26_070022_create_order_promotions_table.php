<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_promotions', function (Blueprint $table) {
            // ใช้ foreignId แบบอ้าง explicit column name ให้ชัด
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('promotion_id');
            $table->timestamps();

            // Primary key ซ้อนคู่
            $table->primary(['order_id', 'promotion_id']);

            // Foreign key constraints
            $table->foreign('order_id')
                ->references('order_id')->on('orders')
                ->onDelete('cascade');

            $table->foreign('promotion_id')
                ->references('promotion_id')->on('promotions')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_promotions');
    }
};
