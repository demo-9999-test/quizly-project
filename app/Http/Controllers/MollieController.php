<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mollie\Laravel\Facades\Mollie;
use Auth;
use DB;

class MollieController extends Controller
{
    //---------------------------prepare code start-----------------------------------
    public function preparePayment(Request $request)
    {
        $user = Auth::user();
        $plan = $request->plan_id;
        $amount = $request->plan_amount;
        $currency = DB::table('currencies')->select('code', 'symbol')->where('default','1')->first();

        $payment = Mollie::api()->payments->create([
            'amount' => [
                'currency' => $currency->code,
                'value' => $amount,
            ],
            'description' => "Buying coins",
            'redirectUrl' => route('mollie.success'),
            'webhookUrl' => 'https://webhook.site/8667115d-e12f-48be-9d7c-05db7c3bfb63',
            'metadata' => [
                'plan_id' => $plan,
                'user_id' => $user->id,
            ],
        ]);
        // Redirect user to Mollie payment screen
        return redirect($payment->getCheckoutUrl(), 303);
    }
    //---------------------------prepare code end-----------------------------------

    //---------------------------success code start-----------------------------------
    public function paymentSuccess(Request $request)
    {

        $paymentId = $request->input('id');

        try {
            $payment = Mollie::api()->payments->get($paymentId);
            \Log::info('Mollie payment ID: ' . $payment->id);
            if ($payment->isPaid()) {
                $plan_id = $payment->metadata->plan_id;
                $plan_amount = $payment->amount->value;
                $txn_id =  $payment->id;
                $checkout = new CheckoutController;
                return $checkout->create_order($txn_id, 'Mollie', $plan_id, $plan_amount, $request->coupon_id, 'success');

            } else {
                return redirect('/')->with('error', 'Payment was not successful. Please try again.');
            }
        } catch (\Exception $e) {
            \Log::error('Mollie Payment Error: ' . $e->getMessage());
            \Log::info('Mollie payment ID: ' . $paymentId);
            return redirect()->route('mollie.failed')->with('error', 'An error occurred while processing your payment. Please contact support.');
        }
    }
    //---------------------------success code end-----------------------------------

    //---------------------------failed code start-----------------------------------

    public function paymentFailed(Request $request)
    {
        $paymentId = $request->input('id');

        try {
            $payment = Mollie::api()->payments->get($paymentId);

            // Check if the payment was not successful
            if (!$payment->isPaid()) {
                $plan_id = $payment->metadata->plan_id;
                $plan_amount = $payment->amount->value;
                $txn_id = $payment->id;

                \Log::error('Mollie payment failed: ' . $payment->status);

                $checkout = new CheckoutController;
                return $checkout->create_order($txn_id, 'Mollie', $plan_id, $plan_amount,$request->coupon_id, 'failed');
            }
        } catch (\Exception $e) {
            // Log the exception
            \Log::error('Mollie payment failed: ' . $e->getMessage());

            // Redirect the user with an error message
            return redirect('/')->with('error', 'An error occurred while processing your payment. Please contact support.');
        }
    }
    //---------------------------failed code end-----------------------------------

    //---------------------------handle webhook code start-----------------------------------
    public function handleWebhook(Request $request)
    {
        $paymentId = $request->input('id');
        $payment = Mollie::api()->payments->get($paymentId);

        if ($payment->isPaid()) {
            // Payment was successful
            $plan_id = $payment->metadata->plan_id;
            $plan_amount = $payment->amount->value;
            $txn_id = $payment->id;
            $checkout = new CheckoutController;
            $checkout->create_order($txn_id, 'Mollie' , $plan_id, $plan_amount,$request->coupon_id,'success');
        }

        return response(null, 200);
    }
    //---------------------------handle webhook code end-----------------------------------

}
