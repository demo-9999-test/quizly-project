<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use auth;
class OmiseController extends Controller
{
    public function pay(Request $request){
        require_once base_path().'/vendor/omise/omise-php/lib/Omise.php';
        define('OMISE_API_VERSION', env('OMISE_API_VERSION'));
        define('OMISE_PUBLIC_KEY', env('OMISE_PUBLIC_KEY'));
        define('OMISE_SECRET_KEY', env('OMISE_SECRET_KEY'));
        try{
            $auth = auth()->user();
            Session::put('plan_id', $request->input('plan_id'));
            Session::put('plan_amount', $request->input('plan_amount'));
            Session::put('coupon_id', $request->input('coupon_id'));
            $charge = \OmiseCharge::create(array(
              'amount' => $request->plan_amount*10000,
              'currency' => 'thb',
              'card' => $_POST["omiseToken"],
              'user' => $auth->id,
                'mobile_number' => $auth->mobile ?? '',
                'email' => $auth->email,
            ));
        }
        catch(\Exception $ex){
            return redirect('/')->with('delete',$ex->getMessage());
        }
        $plan_id = Session::get('plan_id');
        $plan_amount = Session::get('plan_amount');
        $coupon_id = Session::get('coupon_id');
        if($charge['status'] == 'successful'){
            $txnid = $charge['id'];
            $txn_id = $txnid;
            $checkout = new CheckoutController;
            return $checkout->create_order($txn_id,'omise', $plan_id, $plan_amount ,$coupon_id, 'success');
        }else{
            $txnid = $charge['id'];
            $txn_id = $txnid;
            $checkout = new CheckoutController;
            return $checkout->create_order($txn_id,'omise', $plan_id, $plan_amount ,$coupon_id, 'failed');
        }
    }
}
