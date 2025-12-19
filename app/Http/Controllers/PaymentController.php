<?php

namespace App\Http\Controllers;

use App\Models\ManualPayment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\PaymentSetting;
use App\Models\User;
use Laracasts\Flash\Flash;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:apisetting.manage', ['only' => [
            'index', 'stripe_store',
            'paypal_store', 'paystack_store', 'paytm_store', 'omise_store', 'mollie_store', 'mollie_store','rave_store','braintree_store' ,'midtrans_store'
        ]]);
    }

    //---------------------------------- Page View Code start-------------------------------
    public function index()
    {
        $env_files = [
            'STRIPE_KEY'         => env('STRIPE_KEY'),
            'STRIPE_SECRET_KEY'  => env('STRIPE_SECRET_KEY'),

            'PAYPAL_CLIENT_ID'   => env('PAYPAL_CLIENT_ID'),
            'PAYPAL_SECRET_ID'   => env('PAYPAL_SECRET_ID'),
            'PAYPAL_MODE'        => env('PAYPAL_MODE'),


            'RAZORPAY_KEY' => env('RAZORPAY_KEY'),
            'RAZORPAY_SECRET' => env('RAZORPAY_SECRET'),

            'PAYSTACK_PUBLIC_KEY' => env('PAYSTACK_PUBLIC_KEY'),
            'PAYSTACK_SECRET_KEY' => env('PAYSTACK_SECRET_KEY'),
            'PAYSTACK_PAYMENT_URL' => env('PAYSTACK_PAYMENT_URL'),
            'PAYSTACK_CALLBACK_URL' => env('PAYSTACK_CALLBACK_URL'),
            'PAYSTACK_MERCHANT_EMAIL' => env('PAYSTACK_MERCHANT_EMAIL'),

            'PAYTM_ENVIRONMENT' => env('PAYTM_ENVIRONMENT'),
            'PAYTM_MERCHANT_ID' => env('PAYTM_MERCHANT_ID'),
            'PAYTM_MERCHANT_KEY' => env('PAYTM_MERCHANT_KEY'),
            'PAYTM_MERCHANT_WEBSITE' => env('PAYTM_MERCHANT_WEBSITE'),
            'PAYTM_CHANNEL' => env('PAYTM_CHANNEL'),
            'PAYTM_INDUSTRY_TYPE' => env('PAYTM_INDUSTRY_TYPE'),

            'OMISE_PUBLIC_KEY' => env('OMISE_PUBLIC_KEY'),
            'OMISE_SECRET_KEY' => env('OMISE_SECRET_KEY'),
            'OMISE_API_VERSION' => env('OMISE_API_VERSION'),


            'MOLLIE_KEY' => env('MOLLIE_KEY'),


            'FLUTTERWAVE_PUBLIC_KEY' => env('FLUTTERWAVE_PUBLIC_KEY'),
            'FLUTTERWAVE_SECRET_KEY' => env('FLUTTERWAVE_SECRET_KEY'),
            'FLUTTERWAVE_ENCRYPTION_KEY' => env('FLUTTERWAVE_ENCRYPTION_KEY'),

            'BRAINTREE_ENV' => env('BRAINTREE_ENV'),
            'BRAINTREE_MERCHANT_ID' => env('BRAINTREE_MERCHANT_ID'),
            'BRAINTREE_PUBLIC_KEY' => env('BRAINTREE_PUBLIC_KEY'),
            'BRAINTREE_PRIVATE_KEY' => env('BRAINTREE_PRIVATE_KEY'),

            'MIDTRANS_CLIENT_KEY' => env('MIDTRANS_CLIENT_KEY'),
            'MIDTRANS_SERVER_KEY'  => env('MIDTRANS_SERVER_KEY'),
            'MID_TRANS_MODE' => env('MID_TRANS_MODE'),
        ];
        $data['env_files'] = $env_files;
        $settings = PaymentSetting::first();

        return view('admin.payment-gateway.index', compact('env_files', 'settings'));
    }

    //---------------------------------- Page View Code end-------------------------------

    //---------------------------------- Data Store Code start-------------------------------
    public function stripe_store(Request $request)
    {
        $request->validate([
            'STRIPE_KEY' => 'required',
            'STRIPE_SECRET_KEY' => 'required',
        ]);
        $encryptedStripeKey = $request->input('STRIPE_KEY');
        $encryptedStripeSecretKey = $request->input('STRIPE_SECRET_KEY');

        $env_update = DotenvEditor::setKeys([
            'STRIPE_KEY' => $encryptedStripeKey,
            'STRIPE_SECRET_KEY' => $encryptedStripeSecretKey,
        ]);
        $env_update->save();

        $setting = PaymentSetting::firstOrNew();
        $setting->stripe_enable = $request->input('stripe_enable') ? 1 : 0;
        $setting->save();
        return redirect('admin/payment-gateway')->with('success','Data has been updated.');
    }

    public function paypal_store(Request $request)
    {
        $request->validate([
            'PAYPAL_CLIENT_ID' => 'required',
            'PAYPAL_SECRET_ID' => 'required',
            'PAYPAL_MODE' => 'required',
        ]);

        $encryptedPaypalKey = $request->input('PAYPAL_CLIENT_ID');
        $encryptedPaypalSecretKey = $request->input('PAYPAL_SECRET_ID');
        $paypalMode = $request->input('PAYPAL_MODE');

        $env_update = DotenvEditor::setKeys([
            'PAYPAL_CLIENT_ID' => $encryptedPaypalKey,
            'PAYPAL_SECRET_ID' => $encryptedPaypalSecretKey,
            'PAYPAL_MODE' => $paypalMode,
        ]);
        $env_update->save();

        $setting = PaymentSetting::firstOrNew();
        $setting->paypal_enable = $request->input('paypal_enable') ? 1 : 0;
        $setting->save();

        return redirect('admin/payment-gateway')->with('success','Data has been updated.');
    }

    public function razorpay_store(Request $request)
    {
        $request->validate([
            'RAZORPAY_KEY' => 'required',
            'RAZORPAY_SECRET' => 'required',
        ]);
        $encryptedRazorpayKey = $request->input('RAZORPAY_KEY');
        $encryptedRazorpaySecret = $request->input('RAZORPAY_SECRET');

        $env_update = DotenvEditor::setKeys([
            'RAZORPAY_KEY' => $encryptedRazorpayKey,
            'RAZORPAY_SECRET' => $encryptedRazorpaySecret,
        ]);
        $env_update->save();
        $setting = PaymentSetting::firstOrNew();
        $setting->razorpay_enable = $request->input('razorpay_enable') ? 1 : 0;
        $setting->save();

        return redirect('admin/payment-gateway')->with('success','Data has been updated.');
    }

    public function paystack_store(Request $request)
    {
        $request->validate([
            'PAYSTACK_PUBLIC_KEY' => 'required',
            'PAYSTACK_SECRET_KEY' => 'required',
            'PAYSTACK_PAYMENT_URL' => 'required',
            'PAYSTACK_CALLBACK_URL' => 'required',
            'PAYSTACK_MERCHANT_EMAIL' => 'required',
        ]);

        $encryptedPaystackPublicKey = $request->input('PAYSTACK_PUBLIC_KEY');
        $encryptedPaystackSecretKey = $request->input('PAYSTACK_SECRET_KEY');

        $env_update = DotenvEditor::setKeys([
            'PAYSTACK_PUBLIC_KEY' => $encryptedPaystackPublicKey,
            'PAYSTACK_SECRET_KEY' => $encryptedPaystackSecretKey,
            'PAYSTACK_PAYMENT_URL' => $request->input('PAYSTACK_PAYMENT_URL'),
            'PAYSTACK_CALLBACK_URL' => $request->input('PAYSTACK_CALLBACK_URL'),
            'PAYSTACK_MERCHANT_EMAIL' => $request->input('PAYSTACK_MERCHANT_EMAIL'),
        ]);
        $env_update->save();

        $setting = PaymentSetting::firstOrNew();
        $setting->paystack_enable = $request->input('paystack_enable') ? 1 : 0;
        $setting->save();

        return redirect('admin/payment-gateway')->with('success','Data has been updated.');
    }

    public function paytm_store(Request $request)
    {
        $request->validate([
            'PAYTM_ENVIRONMENT' => 'required',
            'PAYTM_MERCHANT_ID' => 'required',
            'PAYTM_MERCHANT_KEY' => 'required',
            'PAYTM_MERCHANT_WEBSITE' => 'required',
            'PAYTM_CHANNEL' => 'required',
            'PAYTM_INDUSTRY_TYPE' => 'required',
        ]);

        // Encrypt Paytm parameters
        $encryptedMerchantId =$request->input('PAYTM_MERCHANT_ID');
        $encryptedMerchantKey = $request->input('PAYTM_MERCHANT_KEY');

        // Update .env with Paytm parameters
        $env_update = DotenvEditor::setKeys([
            'PAYTM_ENVIRONMENT' => $request->input('PAYTM_ENVIRONMENT'),
            'PAYTM_MERCHANT_ID' => $encryptedMerchantId,
            'PAYTM_MERCHANT_KEY' => $encryptedMerchantKey,
            'PAYTM_MERCHANT_WEBSITE' => $request->input('PAYTM_MERCHANT_WEBSITE'),
            'PAYTM_CHANNEL' => $request->input('PAYTM_CHANNEL'),
            'PAYTM_INDUSTRY_TYPE' => $request->input('PAYTM_INDUSTRY_TYPE'),
        ]);
        $env_update->save();

        $setting = PaymentSetting::firstOrNew();
        $setting->paytm_enable = $request->input('paytm_enable') ? 1 : 0;
        $setting->save();
        return redirect('admin/payment-gateway')->with('success','Data has been updated.');
    }

    public function omise_store(Request $request)
    {
        $request->validate([
            'OMISE_PUBLIC_KEY' => 'required',
            'OMISE_SECRET_KEY' => 'required',
            'OMISE_API_VERSION' => 'required',
        ]);

        // Encrypt Omise parameters
        $encryptedPublicKey = $request->input('OMISE_PUBLIC_KEY');
        $encryptedSecretKey = $request->input('OMISE_SECRET_KEY');

        // Update .env with Omise parameters
        $env_update = DotenvEditor::setKeys([
            'OMISE_PUBLIC_KEY' => $encryptedPublicKey,
            'OMISE_SECRET_KEY' => $encryptedSecretKey,
            'OMISE_API_VERSION' => $request->input('OMISE_API_VERSION'),
        ]);
        $env_update->save();
        $setting = PaymentSetting::firstOrNew();
        $setting->omise_enable = $request->input('omise_enable') ? 1 : 0;
        $setting->save();

        return redirect('admin/payment-gateway')->with('success','Data has been updated.');
    }

    public function mollie_store(Request $request)
    {
        $request->validate([
            'MOLLIE_KEY' => 'required',
        ]);
        $encryptedMollieKey = $request->input('MOLLIE_KEY');
        $env_update = DotenvEditor::setKeys([
            'MOLLIE_KEY' => $encryptedMollieKey,
        ]);
        $env_update->save();
        $setting = PaymentSetting::firstOrNew();
        $setting->mollie_enable = $request->input('mollie_enable') ? 1 : 0;
        $setting->save();

        return redirect('admin/payment-gateway')->with('success','Data has been updated.');
    }

    public function rave_store(Request $request)
    {
        $request->validate([
            'FLUTTERWAVE_PUBLIC_KEY' => 'required',
            'FLUTTERWAVE_SECRET_KEY' => 'required',
            'FLUTTERWAVE_ENCRYPTION_KEY' => 'required',
        ]);

        // Encrypt Rave parameters
        $encryptedPublicKey = $request->input('FLUTTERWAVE_PUBLIC_KEY');
        $encryptedSecretKey = $request->input('FLUTTERWAVE_SECRET_KEY');
        $encryptedSecretHash = $request->input('FLUTTERWAVE_ENCRYPTION_KEY');

        // Update .env with Rave parameters
        $env_update = DotenvEditor::setKeys([
            'FLUTTERWAVE_PUBLIC_KEY' => $encryptedPublicKey,
            'FLUTTERWAVE_SECRET_KEY' => $encryptedSecretKey,
            'FLUTTERWAVE_ENCRYPTION_KEY' => $encryptedSecretHash,
        ]);
        $env_update->save();

        $setting = PaymentSetting::firstOrNew();
        $setting->rave_enable = $request->input('rave_enable') ? 1 : 0;
        $setting->save();

        return redirect('admin/payment-gateway')->with('success','Data has been updated.');
    }

    public function braintree_store(Request $request)
    {
        $request->validate([
            'BRAINTREE_ENV' => 'required',
            'BRAINTREE_MERCHANT_ID' => 'required',
            'BRAINTREE_PUBLIC_KEY' => 'required',
            'BRAINTREE_PRIVATE_KEY' => 'required',
        ]);

        // Encrypt Braintree parameters
        $encryptedMerchantId = $request->input('BRAINTREE_MERCHANT_ID');
        $encryptedPublicKey = $request->input('BRAINTREE_PUBLIC_KEY');
        $encryptedPrivateKey = $request->input('BRAINTREE_PRIVATE_KEY');

        // Update .env with Braintree parameters
        $env_update = DotenvEditor::setKeys([
            'BRAINTREE_ENV' => $request->input('BRAINTREE_ENV'),
            'BRAINTREE_MERCHANT_ID' => $encryptedMerchantId,
            'BRAINTREE_PUBLIC_KEY' => $encryptedPublicKey,
            'BRAINTREE_PRIVATE_KEY' => $encryptedPrivateKey,
        ]);
        $env_update->save();

        $setting = PaymentSetting::firstOrNew();
        $setting->braintree_enable = $request->input('braintree_enable') ? 1 : 0;
        $setting->save();
        return redirect('admin/payment-gateway')->with('success','Data has been updated.');
    }

    public function midtrans_store(Request $request)
    {
        $request->validate([
            'MIDTRANS_IS_PRODUCTION' => 'required',
            'MIDTRANS_SERVER_KEY' => 'required',
        ]);

        // Encrypt Midtrans parameters
        $encryptedClientKey = $request->input('MIDTRANS_CLIENT_KEY');
        $encryptedServerKey = $request->input('MIDTRANS_SERVER_KEY');

        // Update .env with Midtrans parameters
        $env_update = DotenvEditor::setKeys([
            'MIDTRANS_CLIENT_KEY' => $encryptedClientKey,
            'MIDTRANS_SERVER_KEY' => $encryptedServerKey,
            'MID_TRANS_MODE' => $request->input('MID_TRANS_MODE') ? 'live' : 'sandbox',

        ]);
        $env_update->save();

        $setting = PaymentSetting::firstOrNew();
        $setting->midtrans_enable = $request->input('midtrans_enable') ? 1 : 0;
        $setting->save();

        return redirect('admin/payment-gateway')->with('success','Data has been updated.');
    }
    //---------------------------------- All Data Show Code start-------------------------------

    public function validatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);
        if (Auth::attempt(['email' => auth()->user()->email, 'password' => $request->input('password')])) {
            return response()->json(['success' => true, 'message' => 'Password is correct.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Incorrect password.']);
        }
    }

    public function manualpay(){
        $payment = ManualPayment::all();
        return view('admin.manual-payment.index',compact('payment'));
    }
    public function manualpaystore(){

    }
}
