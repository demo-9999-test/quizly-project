<?php

namespace App\Http\Controllers;

use Razorpay\Api\Api;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\CheckoutController;

class RazorPayController extends Controller
{
    //--------------------------- dopayment code start --------------------
    public function dopayment(Request $request, $plan_id, $plan_amount)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:packages,id',
            'plan_amount' => 'required|numeric',
        ]);
        $user_email = Auth::user()->email;

        $payment_status = 'failed';
        $txn_id = null;

        if(env('RAZORPAY_KEY') == '' || env('RAZORPAY_SECRET') == ''){
            return redirect('/')->with('error', "Razorpay Key Not Found Please Contact your Site Admin");
        }
        if ($request->has('razorpay_payment_id')) {
            $payment_status = 'success';
            $txn_id = $request->razorpay_payment_id;
            $payment_method = 'RazorPay';

            $checkout = new CheckoutController;
            return $checkout->create_order($txn_id, $payment_method, $plan_id, $plan_amount,$request->coupon_id ,$payment_status);
        }
        else {
            $payment_status = 'failed';
            $checkout = new CheckoutController;
            return $checkout->create_order($txn_id, 'razorpay', $plan_id, $plan_amount,$request->coupon_id , $payment_status);
        }
    }
    //--------------------------- dopayment code end--------------------
}
