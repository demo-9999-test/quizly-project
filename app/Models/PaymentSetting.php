<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    use HasFactory;
    protected $table = 'payment_settings';
    protected $fillable = [
        'stripe_enable',
        'paypal_enable',
        'instamojo_enable',
        'razorpay_enable',
        'paystack_enable',
        'paytm_enable',
        'omise_enable',
        'payu_enable',
        'mollie_enable',
        'cashfree_enable',
        'skrill_enable',
        'rave_enable',
        'payhere_enable',
        'iyzico_enable',
        'ssl_enable',
        'aamarpay_enable',
        'braintree_enable',
        'payflexi_enable',
        'esawa_enable',
        'smanager_enable',
        'paytabs_enable',
        'dpo_enable',
        'authorize_enable',
        'bkash_enable',
        'midtrans_enable',
        'square_enable',
        'worldpay_enable',
        'onepay_enable',
    ];
}
