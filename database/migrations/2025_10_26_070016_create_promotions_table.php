<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id('promotion_id');                   // PK ชื่อ custom
            $table->string('name');                       // ชื่อโปรโมชัน
            $table->string('promotion_photo')->nullable();// รูปใน public/images/promotions
            $table->decimal('discount_percent', 5, 2);    // เช่น 30.00
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
