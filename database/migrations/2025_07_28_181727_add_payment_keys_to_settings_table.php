<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->text('stripe_key')->nullable();
            $table->text('stripe_secret_key')->nullable();
            $table->text('paypal_client_id')->nullable();
            $table->text('paypal_secret_id')->nullable();
            $table->text('razorpay_key')->nullable();
            $table->text('razorpay_secret_key')->nullable();
            $table->text('paystack_public_key')->nullable();
            $table->text('paystack_secret_key')->nullable();
            $table->text('paytm_merchant_id')->nullable();
            $table->text('paytm_merchant_key')->nullable();
            $table->text('omise_public_key')->nullable();
            $table->text('omise_secret_key')->nullable();
            $table->text('mollie_key')->nullable();
            $table->text('flutterwave_public_key')->nullable();
            $table->text('flutterwave_secret_key')->nullable();
            $table->text('flutterwave_encryption_key')->nullable();
            $table->text('braintree_merchant_id')->nullable();
            $table->text('braintree_public_key')->nullable();
            $table->text('braintree_private_key')->nullable();
            $table->text('midtrans_client_key')->nullable();
            $table->text('midtrans_server_key')->nullable();
            // Add other keys as needed
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'stripe_key',
                'stripe_secret_key',
                'paypal_client_id',
                'paypal_secret_id',
                'razorpay_key',
                'razorpay_secret_key',
                'paystack_public_key',
                'paystack_secret_key', 
                'paytm_merchant_id',
                'paytm_merchant_key',
                'omise_public_key',
                'omise_secret_key',
                'mollie_key',
                'flutterwave_public_key',
                'flutterwave_secret_key',
                'flutterwave_encryption_key',
                'braintree_merchant_id',
                'braintree_public_key',
                'braintree_private_key',
                'midtrans_client_key',
                'midtrans_server_key',

            ]);
        });
    }
};
