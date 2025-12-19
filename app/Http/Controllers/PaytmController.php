<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;
use App\Models\FailedTxn;
use Anand\LaravelPaytmWallet\Facades\PaytmWallet;
use Illuminate\Support\Str;

class PaytmController extends Controller
{
    //--------------------------- pay code start --------------------
    public function pay(Request $request)
    {
        $user = Auth::user();
        $currency = DB::table('currencies')->select('code', 'symbol')->where('default','1')->first();
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to continue.');
        }
        if($currency == null){
            return back()->with('error', 'Please set default currency in currency module.');
        }
        if ($currency->code != 'INR') {
            return back()->with('error', 'Currency is in '.$currency->code.' Paytm only support INR currency.');
        }
        if ($user->mobile == null) {
            return back()->with('error', 'Please update your mobile number in profile section.');
        }
        if(env('PAYTM_MERCHANT_ID') == '' || env('PAYTM_MERCHANT_KEY') == ''){
            return back()->with('error', "Paytm Key Not Found Please Contact your Site Admin");
        }
        $payment = PaytmWallet::with('receive');
        Session::put('plan_id', $request['plan_id']);
        Session::put('plan_amount', $request['plan_amount']);
        Session::put('coupon_id', $request['coupon_id']);
        $payment->prepare([
            'order' => rand(1,100),
            'user' => $user->id,
            'mobile_number' => $user->mobile,
            'email' => $user->email,
            'amount' => $request->plan_amount,
            'callback_url' => url('payment/paytm/status')
          ]);
        return $payment->receive();
    }
    //--------------------------- pay code end --------------------

    //--------------------------- payment callback code start --------------------
    public function paymentCallback(Request $request)
    {
        $plan_id = Session::get('plan_id');
        $plan_amount = Session::get('plan_amount');
        $coupon_id = Session::get('coupon_id');
        $payment_method = 'paytm';
        Session::forget(['plan_id','plan_amount']);
        $transaction = PaytmWallet::with('receive');
        $response = $transaction->response();
        $order_id = $transaction->getOrderId();
        $payment_status = null;

        if ($transaction->isSuccessful()) {
            $payment_status = 'success';
            $txn_id = $transaction->getTransactionId();
            $checkout = new CheckoutController();
            return $checkout->createorder($txn_id, $payment_method, $plan_id, $plan_amount, $coupon_id , $payment_status);
        } elseif ($transaction->isFailed()) {
            $res = $transaction->getResponseMessage();
            $this->create_failed_txn('paytm', $request->plan_id, $request->plan_amount,$coupon_id);
            return redirect('/')->with('error', $res);
        } elseif ($transaction->isPending()) {
            $res = $transaction->getResponseMessage();
            $this->create_failed_txn('paytm', $request->plan_id, $request->plan_amount,$coupon_id);
            return redirect('/')->with('info', $res);
        }

        return redirect('/')->with('error', 'Unexpected transaction status.');
    }
    //--------------------------- payment callback code end --------------------

    //--------------------------- failed_tnx code start --------------------
    protected function create_failed_txn($gateway, $plan_id, $amount,$coupon_id)
    {
        $checkout = new CheckoutController();
        $txn_id = 'failed_' . uniqid();

        return $checkout->create_order($txn_id, $gateway, $plan_id, $amount, $coupon_id,'failed');
    }
    //--------------------------- failed_tnx code end --------------------
}
