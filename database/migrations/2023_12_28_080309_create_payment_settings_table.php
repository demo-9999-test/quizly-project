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
        if(!Schema::hasTable('payment_settings')){

        Schema::create('payment_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('stripe_enable')->default(0);
            $table->boolean('paypal_enable')->default(0);
            $table->boolean('instamojo_enable')->default(0);
            $table->boolean('razorpay_enable')->default(0);
            $table->boolean('paystack_enable')->default(0);
            $table->boolean('paytm_enable')->default(0);
            $table->boolean('omise_enable')->default(0);
            $table->boolean('payu_enable')->default(0);
            $table->boolean('mollie_enable')->default(0);
            $table->boolean('cashfree_enable')->default(0);
            $table->boolean('skrill_enable')->default(0);
            $table->boolean('rave_enable')->default(0);
            $table->boolean('payhere_enable')->default(0);
            $table->boolean('iyzico_enable')->default(0);
            $table->boolean('ssl_enable')->default(0);
            $table->boolean('aamarpay_enable')->default(0);
            $table->boolean('braintree_enable')->default(0);
            $table->boolean('payflexi_enable')->default(0);
            $table->boolean('esawa_enable')->default(0);
            $table->boolean('smanager_enable')->default(0);
            $table->boolean('paytabs_enable')->default(0);
            $table->boolean('dpo_enable')->default(0);
            $table->boolean('authorize_enable')->default(0);
            $table->boolean('bkash_enable')->default(0);
            $table->boolean('midtrans_enable')->default(0);
            $table->boolean('square_enable')->default(0);
            $table->boolean('worldpay_enable')->default(0);
            $table->boolean('onepay_enable')->default(0);
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_settings');
    }
};
