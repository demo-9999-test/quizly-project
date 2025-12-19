<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Braintree\Configuration;
class BraintreeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        Configuration::environment(config('services.braintree.environment'));
        Configuration::merchantId(config('services.braintree.merchant_id'));
        Configuration::publicKey(config('services.braintree.public_key'));
        Configuration::privateKey(config('services.braintree.private_key'));
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
