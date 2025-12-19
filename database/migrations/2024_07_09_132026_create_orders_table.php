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
        if(!Schema::hasTable('orders')){
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('package_id');
                $table->foreign('user_id')->references('id')->on('users');
                $table->foreign('package_id')->references('id')->on('packages');
                $table->string('transaction_id');
                $table->string('payment_method');
                $table->integer('total_amount');
                $table->integer('coupon_discount');
                $table->string('currency_name');
                $table->string('currency_icon');
                $table->string('status');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
