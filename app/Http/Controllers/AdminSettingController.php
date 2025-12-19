<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Settings;

class AdminSettingController extends Controller
{
    // Show Settings Page
    public function settingsPage()
    {
        return view('admin.settings', [
            'env_files' => [
                'STRIPE_KEY' => env('STRIPE_KEY'),
                'STRIPE_SECRET_KEY' => env('STRIPE_SECRET_KEY'),
            ],
            'settings' => \App\Models\Settings::first(),
        ]);
    }

    // Show Stripe Keys after password verification
    public function showStripeKeys(Request $request)
{
    $request->validate([
        'password' => 'required',
    ]);

    $user = Auth::user();

    if (!Hash::check($request->password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Incorrect password',
        ]);
    }

    // ✅ Read from settings table instead of env
    $settings = \App\Models\Settings::first();

    return response()->json([
        'success' => true,
        'stripe_key' => $settings->stripe_key,
        'secret_key' => $settings->stripe_secret_key,
    ]);
}

    public function stripeStore(Request $request)
{
    $request->validate([
        'stripe_key' => 'required|string',
        'stripe_secret_key' => 'required|string',
    ]);

    // Save to DB or env (depending on your setup)
    // Example: saving to settings table
    $settings = \App\Models\Settings::first();
    $settings->stripe_key = $request->stripe_key;
    $settings->stripe_secret_key = $request->stripe_secret_key;
    $settings->stripe_enable = $request->stripe_enable ? 1 : 0;
    $settings->save();

    return back()->with('success', 'Stripe keys updated successfully.');
}

// PAYPAL CONTROLLER

public function showPaypalClientID(Request $request)
{
    $request->validate([
        'password' => 'required',
    ]);

    $user = Auth::user();

    if (!Hash::check($request->password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Incorrect password',
        ]);
    }

    $settings = \App\Models\Settings::first();
    
    return response()->json([
        'success' => true,
        'paypal_client_id' => $settings->paypal_client_id,
        'paypal_secret_id' => $settings->paypal_secret_id,
    ]);
}

    public function paypalStore(Request $request)
{
    $request->validate([
        'paypal_client_id' => 'required|string',
        'paypal_secret_id' => 'required|string',
    ]);

    // Save to DB or env (depending on your setup)
    // Example: saving to settings table
    $settings = \App\Models\Settings::first();
    $settings->paypal_client_id = $request->paypal_client_id;
    $settings->paypal_secret_id = $request->paypal_secret_id;
    $settings->paypal_enable = $request->paypal_enable ? 1 : 0;
    $settings->save();

    return back()->with('success', 'Paypal keys updated successfully.');
}

// RAZORPAY CONTROLLER

public function showRazorpayKeys(Request $request)
{
    $request->validate([
        'password' => 'required',
    ]);

    $user = Auth::user();

    if (!Hash::check($request->password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Incorrect password',
        ]);
    }
    
    // ✅ Read from settings table instead of env
    $settings = \App\Models\Settings::first();

    return response()->json([
        'success' => true,
        'razorpay_key' => $settings->razorpay_key,
        'razorpay_secret_key' => $settings->razorpay_secret_key,
    ]);
}

    public function razorpayStore(Request $request)
{
    $request->validate([
        'razorpay_key' => 'required|string',
        'razorpay_secret_key' => 'required|string',
    ]);

    // Save to DB or env (depending on your setup)
    // Example: saving to settings table
    $settings = \App\Models\Settings::first();
    $settings->razorpay_key = $request->razorpay_key;
    $settings->razorpay_secret_key = $request->razorpay_secret_key;
    $settings->razorpay_enable = $request->razorpay_enable ? 1 : 0;
    $settings->save();

    return back()->with('success', 'Razorpay keys updated successfully.');
}

// PAYSTACK CONTROLLER

public function showPaystackKeys(Request $request)
{
    $request->validate([
        'password' => 'required',
    ]);

    $user = Auth::user();

    if (!Hash::check($request->password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Incorrect password',
        ]);
    }

    // ✅ Read from settings table instead of env
    $settings = \App\Models\Settings::first();

    return response()->json([
        'success' => true,
        'paystack_public_key' => $settings->paystack_public_key,
        'paystack_secret_key' => $settings->paystack_secret_key,
    ]);
}
    public function paystackStore(Request $request)
{
    $request->validate([
        'paystack_public_key' => 'required|string',
        'paystack_secret_key' => 'required|string',
    ]);

    // Save to DB or env (depending on your setup)
    // Example: saving to settings table
    $settings = \App\Models\Settings::first();
    $settings->paystack_public_key = $request->paystack_public_key;
    $settings->paystack_secret_key = $request->paystack_secret_key;
    $settings->paystack_enable = $request->paystack_enable ? 1 : 0;
    $settings->save();

    return back()->with('success', 'Paystack keys updated successfully.');
}

// PAYTM CONTROLLER

public function showPaytmKeys(Request $request)
{
    $request->validate([
        'password' => 'required',
    ]);

    $user = Auth::user();

    if (!Hash::check($request->password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Incorrect password',
        ]);
    }

    // ✅ Read from settings table instead of env
    $settings = \App\Models\Settings::first();

    return response()->json([
        'success' => true,
        'paytm_merchant_id' => $settings->paytm_merchant_id,
        'paytm_merchant_key' => $settings->paytm_merchant_key,
    ]);
}

    public function paytmStore(Request $request)
{
    $request->validate([
        'paytm_merchant_id' => 'required|string',
        'paytm_merchant_key' => 'required|string',
    ]);

    // Save to DB or env (depending on your setup)
    // Example: saving to settings table
    $settings = \App\Models\Settings::first();
    $settings->paytm_merchant_id = $request->paytm_merchant_id;
    $settings->paytm_merchant_key = $request->paytm_merchant_key;
    $settings->paytm_enable = $request->paytm_enable ? 1 : 0;
    $settings->save();

    return back()->with('success', 'Paytm keys updated successfully.');
}

// OMISE CONTROLLER

public function showOmiseKeys(Request $request)
{
    $request->validate([
        'password' => 'required',
    ]);

    $user = Auth::user();

    if (!Hash::check($request->password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Incorrect password',
        ]);
    }

    // ✅ Read from settings table instead of env
    $settings = \App\Models\Settings::first();

    return response()->json([
        'success' => true,
        'omise_public_key' => $settings->omise_public_key,
        'omise_secret_key' => $settings->omise_secret_key,
    ]);
}

    public function omiseStore(Request $request)
{
    $request->validate([
        'omise_public_key' => 'required|string',
        'omise_secret_key' => 'required|string',
    ]);

    // Save to DB or env (depending on your setup)
    // Example: saving to settings table
    $settings = \App\Models\Settings::first();
    $settings->omise_public_key = $request->omise_public_key;
    $settings->omise_secret_key = $request->omise_secret_key;
    $settings->omise_enable = $request->omise_enable ? 1 : 0;
    $settings->save();

    return back()->with('success', 'Omise keys updated successfully.');
}

// MOLLIE CONTROLLER

public function showMollieKeys(Request $request)
{
    $request->validate([
        'password' => 'required',
    ]);

    $user = Auth::user();

    if (!Hash::check($request->password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Incorrect password',
        ]);
    }

    // ✅ Read from settings table instead of env
    $settings = \App\Models\Settings::first();

    return response()->json([
        'success' => true,
        'mollie_key' => $settings->mollie_key,
    ]);
}

    public function mollieStore(Request $request)
{
    $request->validate([
        'mollie_key' => 'required|string',
    ]);

    // Save to DB or env (depending on your setup)
    // Example: saving to settings table
    $settings = \App\Models\Settings::first();
    $settings->mollie_key = $request->mollie_key;
    $settings->mollie_enable = $request->mollie_enable ? 1 : 0;
    $settings->save();

    return back()->with('success', 'Mollie key updated successfully.');
}

// RAVE CONTROLLER

public function showRaveKeys(Request $request)
{
    $request->validate([
        'password' => 'required',
    ]);

    $user = Auth::user();

    if (!Hash::check($request->password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Incorrect password',
        ]);
    }

    // ✅ Read from settings table instead of env
    $settings = \App\Models\Settings::first();

    return response()->json([
        'success' => true,
        'flutterwave_public_key' => $settings->flutterwave_public_key,
        'flutterwave_secret_key' => $settings->flutterwave_secret_key,
        'flutterwave_encryption_key' => $settings->flutterwave_encryption_key,
    ]);
}
    public function raveStore(Request $request)
{
    $request->validate([
        'flutterwave_public_key' => 'required|string',
        'flutterwave_secret_key' => 'required|string',
        'flutterwave_encryption_key' => 'required|string',
    ]);

    // Save to DB or env (depending on your setup)
    // Example: saving to settings table
    $settings = \App\Models\Settings::first();
    $settings->flutterwave_public_key = $request->flutterwave_public_key;
    $settings->flutterwave_secret_key = $request->flutterwave_secret_key;
    $settings->flutterwave_encryption_key = $request->flutterwave_encryption_key;
    $settings->flutterwave_enable = $request->flutterwave_enable ? 1 : 0;
    $settings->save();

    return back()->with('success', 'Rave keys updated successfully.');
}

// BRAINTREE CONTROLLER

public function showBraintreeKeys(Request $request)
{
    $request->validate([
        'password' => 'required',
    ]);

    $user = Auth::user();

    if (!Hash::check($request->password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Incorrect password',
        ]);
    }

    // ✅ Read from settings table instead of env
    $settings = \App\Models\Settings::first();

    return response()->json([
        'success' => true,
        'braintree_merchant_id' => $settings->braintree_merchant_id,
        'braintree_public_key' => $settings->braintree_public_key,
        'braintree_private_key' => $settings->braintree_private_key,
    ]);
}
    public function braintreeStore(Request $request)
{
    $request->validate([
        'braintree_merchant_id' => 'required|string',
        'braintree_public_key' => 'required|string',
        'braintree_private_key' => 'required|string',
    ]);

    // Save to DB or env (depending on your setup)
    // Example: saving to settings table
    $settings = \App\Models\Settings::first();
    $settings->braintree_merchant_id = $request->braintree_merchant_id;
    $settings->braintree_public_key = $request->braintree_public_key;
    $settings->braintree_private_key = $request->braintree_private_key;
    $settings->braintree_enable = $request->braintree_enable ? 1 : 0;
    $settings->save();

    return back()->with('success', 'Braintree keys updated successfully.');
}

// MIDTRANS CONTROLLER

public function showMidtransKeys(Request $request)
{
    $request->validate([
        'password' => 'required',
    ]);

    $user = Auth::user();

    if (!Hash::check($request->password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Incorrect password',
        ]);
    }

    return response()->json([
        'success' => true,
        'midtrans_client_key' => env('MIDTRANS_CLIENT_KEY'),
        'midtrans_server_key' => env('MIDTRANS_SERVER_KEY'),
    ]);
}

    public function midtransStore(Request $request)
{
    $request->validate([
        'midtrans_client_key' => 'required|string',
        'midtrans_server_key' => 'required|string',
    ]);

    // Save to DB or env (depending on your setup)
    // Example: saving to settings table
    $settings = \App\Models\Settings::first();
    $settings->midtrans_client_key = $request->midtrans_client_key;
    $settings->midtrans_server_key = $request->midtrans_server_key;
    $settings->midtrans_enable = $request->midtrans_enable ? 1 : 0;
    $settings->save();

    return back()->with('success', 'Midtrans keys updated successfully.');
}

}
