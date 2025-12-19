<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Validator;
use DB;
use App\Models\Packages;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Auth;
use Cartalyst\Stripe\Exception\CardErrorException;

class StripeController extends Controller
{
    //---------------------------------- Payment code start -----------------------------------
    public function Payment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plan_amount' => 'required',
            'plan_id' => 'required',
            'paymentMethodId' => 'required'
        ]);

        if(!$validator->passes()) {
            return redirect('/')->with('error','All fields are required !!');
        }

        $auth = Auth::user();
        $plan = Packages::where('id', $request->plan_id)->first();
        $amount = $request->plan_amount;

        $currency = DB::table('currencies')->select('code', 'symbol')->where('default','1')->first();

        if($currency == null){
            return back()->with('error', 'Please set default currency in currency module.');
        }

        $stripe = Stripe::make(env('STRIPE_SECRET_KEY'));

        if($stripe == '' || $stripe == null){
            \Log::error('Stripe key not found in environment');
            return redirect('/')->with('error', "Stripe Key Not Found Please Contact your Site Admin");
        }
        if(env('STRIPE_KEY') == '' || env('STRIPE_SECRET_KEY') == ''){
            return redirect('/')->with('error', "Stripe Key Not Found Please Contact your Site Admin");
        }
        try {
            if ($auth->stripe_id == null) {
                $customer = $this->createCustomer($stripe, $auth);
            }

            $paymentIntent = $stripe->paymentIntents()->create([
                'amount' => $amount * 100, // Stripe expects amount in cents
                'currency' => $currency->code,
                'payment_method' => $request->paymentMethodId,
                'customer' => $auth->stripe_id,
                'confirm' => true,
                'description' => "One Time charge for ". $request->plan_id,
            ]);
            if($paymentIntent['status'] == 'succeeded') {
                $txn_id = $paymentIntent['id'];
                $checkout = new CheckoutController;
                return $checkout->create_order($txn_id, 'stripe', $request->plan_id, $amount,$request->coupon_id ,'success');
            } elseif ($paymentIntent['status'] == 'requires_action') {
                // 3D Secure authentication is required
                return response()->json([
                    'requires_action' => true,
                    'payment_intent_client_secret' => $paymentIntent['client_secret']
                ]);
            }

            $this->create_failed_txn('stripe', $request->plan_id, $request->plan_amount,$request->coupon_id);
            return redirect()->route('checkout.page',['id' =>$request->plan_id ])->with('error', 'Payment error occurred. Please try again !');

        } catch (CardErrorException $e) {
            $this->create_failed_txn('stripe', $request->plan_id, $request->plan_amount,$request->coupon_id);
            return redirect()->route('checkout.page',['id' =>$request->plan_id ])->with('error', $e->getMessage().' Payment error occurred. Please try again!');
        } catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {
            $this->create_failed_txn('stripe', $request->plan_id, $request->plan_amount,$request->coupon_id);
            return redirect()->route('checkout.page',['id' =>$request->plan_id ])->with('error', $e->getMessage().' Payment error occurred. Please try again!');
        }
    }
    //---------------------------------- Payment code end -----------------------------------

    //---------------------------------- createCustomer code start -----------------------------------
    private function createCustomer($stripe, $auth)
    {
        $customer = $stripe->customers()->create([
            'email' => $auth->email,
            'name' => $auth->name,
            'address' => [
                'line1' => $auth->address
            ],
        ]);
        if(isset($customer['id'])){
            // $auth->stripe_id = $customer['id'];
            $auth->save();
        }
        return $customer;
    }
    //---------------------------------- createCustomer code end-----------------------------------

    //---------------------------------- createplan code start -----------------------------------
    private function createPlan($stripe, $plan, $currency)
    {
        $stripe_plan = $stripe->plans()->create([
            'id'                   => $plan->name."_".$plan->plan_id,
            'name'                 => $plan->name,
            'amount'               => $plan->plan_amount,
            'currency'             => $currency->code,
        ]);
        if(isset($stripe_plan['id'])){
            $plan->stripe_product_id = $stripe_plan['id'];
            $plan->save();
        }
        return $stripe_plan;
    }
    //---------------------------------- createplan code end -----------------------------------

    //---------------------------------- create_failerd_tnx code start -----------------------------------
    protected function create_failed_txn($gateway, $plan_id, $amount,$coupon_id)
    {
        $checkout = new CheckoutController();
        $txn_id = 'failed_' . uniqid();

        return $checkout->create_order($txn_id, $gateway, $plan_id, $amount, $coupon_id, 'failed');
    }
    //---------------------------------- create_failerd_tnx code end-----------------------------------
}
