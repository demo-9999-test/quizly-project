<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $table = 'settings';
    protected $fillable = [
        'login_img',
        'signup_img',
        'right_click_status',
        'preloader_enable_status',
        'inspect_status',
        'mobile_status',
        'cookie_status',
        'activity_status',
        'welcome_status',
        'verify_status',
        'admin_logo',
        'message',

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
    ];
}
