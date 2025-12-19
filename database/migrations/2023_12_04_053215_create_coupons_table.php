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
        if(!Schema::hasTable('coupons')){
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_code')->nullable();
            $table->string('discount_type')->nullable();
            $table->string('amount')->nullable();
            $table->string('min_amount')->nullable();
            $table->string('max_amount')->nullable();
            $table->string('expiry_date')->nullable();
            $table->string('start_date')->nullable();
            $table->string('limit')->nullable();
            $table->integer('code_display')->default(0);
            $table->integer('active_user')->default(0);
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
