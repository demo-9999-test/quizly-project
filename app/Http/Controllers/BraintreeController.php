<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Braintree\Gateway;
use DB;
class BraintreeController extends Controller
{
    protected $gateway;

    public function __construct()
    {
        $this->gateway = new Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchant_id'),
            'publicKey' => config('services.braintree.public_key'),
            'privateKey' => config('services.braintree.private_key')
        ]);
    }
    //------------------- braintree client token get start --------------------------------
    public function getClientToken()
    {
        try {
            $clientToken = $this->gateway->clientToken()->generate();
            return response()->json(['clientToken' => $clientToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    //------------------- braintree client token get end --------------------------------

    //------------------- braintree initiate payment start --------------------------------
    public function initiatePayment(Request $request)
    {
        try {
            $currency = DB::table('currencies')->select('code', 'symbol')->where('default', '1')->first();
            if ($currency == null) {
                throw new \Exception('Please set default currency in currency module.');
            }

            if (env('BRAINTREE_MERCHANT_ID') == '' || env('BRAINTREE_PUBLIC_KEY') == '' || env('BRAINTREE_PRIVATE_KEY') == '') {
                throw new \Exception("Braintree Key Not Found. Please Contact your Site Admin");
            }

            $clientToken = $this->gateway->clientToken()->generate();

            // Store plan ID and amount in session for later use
            session([
                'braintree_plan_id' => $request->plan_id,
                'braintree_amount' => $request->plan_amount
            ]);

            return view('braintree.payment', [
                'clientToken' => $clientToken,
                'amount' => $request->plan_amount,
                'planId' => $request->plan_id
            ]);
        } catch (\Exception $e) {
            \Log::error('Braintree Payment Initiation Error: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to initiate payment: ' . $e->getMessage()]);
        }
    }
    //------------------- braintree initiate payment end --------------------------------

    //------------------- braintree process payment start --------------------------------
    public function processPayment(Request $request)
    {
        try {
            $nonce = $request->payment_method_nonce;
            $amount = session('braintree_amount') ?? $request->amount;
            $planId = session('braintree_plan_id') ?? $request->plan_id;

            \Log::info('Payment data:', [
                'user_id' => auth()->id(),
                'braintree_amount' => $amount,
                'braintree_plan_id' => $planId
            ]);

            if (!$amount || !$planId) {
                throw new \Exception('Payment data is missing. Please try again.');
            }

            $result = $this->gateway->transaction()->sale([
                'amount' => $amount,
                'paymentMethodNonce' => $nonce,
                'options' => [
                    'submitForSettlement' => true
                ]
            ]);

            if ($result->success) {
                $transactionId = $result->transaction->id;
                $checkout = new CheckoutController;
                $checkout->create_order($transactionId, 'braintree', $planId, $amount, $request->coupon_id,  'success');

                // Clear the session data after successful payment
                session()->forget(['braintree_plan_id', 'braintree_amount']);

                return response()->json([
                    'success' => true,
                    'redirect' => route('home.page')
                ]);
            } else {
                $transactionId = $result->transaction ? $result->transaction->id : null;
                $checkout = new CheckoutController;
                $checkout->create_order($transactionId, 'braintree', $planId, $amount, $request->coupon_id, 'failed');

                return response()->json([
                    'success' => false,
                    'error' => $result->message
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Braintree Payment Processing Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'An error occurred while processing the payment: ' . $e->getMessage()
            ], 500);
        }
    }
    //------------------- braintree process payment end --------------------------------

}
