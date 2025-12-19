<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Unicodeveloper\Paystack\Paystack;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class PaystackController extends Controller
{
    //--------------------------- Gateway code start --------------------
    public function redirectToGateway(Request $request)
    {
        $currency = DB::table('currencies')->select('code', 'symbol')->where('default','1')->first();
        if($currency == null){
            return back()->with('error', 'Please set default currency in currency module.');
        }
        if(env('PAYSTACK_PUBLIC_KEY') == '' || env('PAYSTACK_SECRET_KEY') == '' || env('PAYSTACK_CALLBACK_URL') == ''){
            return redirect('/')->with('error', "Paystack Key Not Found Please Contact your Site Admin");
        }

        try {
            Session::put('plan_id', $request->input('plan_id'));
            Session::put('plan_amount', $request->input('plan_amount'));
            Session::put('coupon_id',$request->input('coupon_id'));
            $auth = Auth::user();
            $data = [
                'order' => rand(1, 100),
                'user' => $auth->id,
                'mobile_number' => $auth->mobile ?? '',
                'email' => $auth->email,
                'amount' => (int) (($request->plan_amount) * (100)),
                'reference' => uniqid(),
                'currency' => 'NGN',
                'callback_url' => route('paystack.callback')
            ];
            $paystack = new \Unicodeveloper\Paystack\Paystack();
        return $paystack->getAuthorizationUrl($data)->redirectNow();
        } catch(\Exception $e) {
            \Session::flash('delete', $e->getMessage());
            return $e;
        }
    }
    //--------------------------- Gateway code end --------------------

    //--------------------------- handleGateway code start --------------------
    public function handleGatewayCallback()
    {
        try {
            $paystack = new \Unicodeveloper\Paystack\Paystack();
            $paymentDetails = $paystack->getPaymentData();
            $plan_id = Session::get('plan_id');
            $plan_amount = Session::get('plan_amount');
            $coupon_id = Session::get('coupon_id');
            $paymentDetails = json_decode(json_encode($paymentDetails), true);
            $paymentdata = $paymentDetails['data'];

            if ($paymentDetails['status'] === true) {
                $txn_id = $paymentdata['reference'];
                $payment_method = 'Paystack';
                $checkout = new CheckoutController;
                return $checkout->create_order($txn_id, $payment_method, $plan_id, $plan_amount,$coupon_id ,'success');
            }else {
                // Payment failed
                $txn_id = $paymentdata['reference'] ?? 'N/A';
                $payment_method = 'Paystack';
                $checkout = new CheckoutController;
                return $checkout->create_order($txn_id, $payment_method, $plan_id, $plan_amount,$coupon_id , 'failed');
            }
        } catch (\Exception $ex) {
            Session::flash('delete', $ex->getMessage());
            return redirect('/');
        }
    }
    //--------------------------- handleGateway code end --------------------
}
