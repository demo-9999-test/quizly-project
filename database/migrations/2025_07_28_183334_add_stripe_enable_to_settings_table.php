<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('stripe_enable')->default(false);
            $table->boolean('paypal_enable')->default(false);
            $table->boolean('razorpay_enable')->default(false);
            $table->boolean('paystack_enable')->default(false);
            $table->boolean('paytm_enable')->default(false);
            $table->boolean('omise_enable')->default(false);
            $table->boolean('mollie_enable')->default(false); 
            $table->boolean('flutterwave_enable')->default(false); 
            $table->boolean('braintree_enable')->default(false); 
            $table->boolean('midtrans_enable')->default(false); // or use `tinyInteger` if needed
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('stripe_enable');
            $table->dropColumn('paypal_enable');
            $table->dropColumn('razorpay_enable');
            $table->dropColumn('paystack_enable');
            $table->dropColumn('paytm_enable');
            $table->dropColumn('omise_enable');
            $table->dropColumn('mollie_enable');
            $table->dropColumn('flutterwave_enable');
            $table->dropColumn('braintree_enable');
            $table->dropColumn('midtrans_enable');
        });
    }
};
