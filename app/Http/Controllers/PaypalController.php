<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Packages;
use Illuminate\Support\Str;
use App\Models\FailedTxn;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    protected $provider;

    public function __construct()
    {
        $this->provider = new PayPalClient;
        $this->provider->setApiCredentials(config('paypal'));
        $this->provider->getAccessToken();
    }
    //--------------------------- pay code start -----------------------
    public function paywithpaypal(Request $request)
    {
        $user = Auth::user();
        $currency = DB::table('currencies')->select('code', 'symbol')->where('default','1')->first();
        if($currency == null){
            return back()->with('error', 'Please set default currency in currency module.');
        }
        if($currency->code == 'INR' && env('PAYPAL_MODE') == 'sandbox'){
        return redirect('/')
                ->with('error', 'INR is not supported in paypal sandbox mode try with other currency !');
        }

        if(env('PAYPAL_MODE') == '' || env('PAYPAL_CLIENT_ID') == '' || env('PAYPAL_CLIENT_SECRET') == ''){
        return redirect('/')->with('error', "Paypal Key Not Found Please Contact your Site Admin");
        }
        $plan = Packages::where('id',$request->plan_id)->first();
        $this->provider->setCurrency($currency->code);

        $response = $this->provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal_success'),
                "cancel_url" => route('paypal_cancel'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => $currency->code,
                        "value" => $request['plan_amount']
                    ]
                ]
            ]
        ]);
        if (isset($response) && isset($response['id']) && $response['id'] != null) {
        // add payment ID to session
            Session::put('paypal_payment_id', $response['id']);
            Session::put('plan_id', $plan->id);
            Session::put('plan_amount', $request['plan_amount']);
            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            $this->create_failed_txn('paypal', $request->plan_id, $request->plan_amount,$request->coupon_id);
            return redirect('/')->with('error', '1 Something went wrong.');
        } else {
            $this->create_failed_txn('paypal', $request->plan_id, $request->plan_amount,$request->coupon_id);
            return redirect('/')->with('error', $response['message'] ?? '2 Something went wrong.');
        }
    }
    //--------------------------- pay code end -----------------------

    //--------------------------- pay_sucess code start -----------------------
    public function paypal_success(Request $request)
    {
        // Get the payment ID, plan, and amount from the session
        $txn_id = Session::get('paypal_payment_id');
        $plan = Session::get('plan_id');
        $plan_amount = Session::get('plan_amount');

        // If session data is missing, redirect to home with an error
        if (!$txn_id || !$plan || !$plan_amount) {
            return redirect()->route('home.page')->with('error', 'Invalid session data. Please try again.');
        }
        try {
            $response = $this->provider->capturePaymentOrder($request['token']);

            if (isset($response['status']) && $response['status'] == 'COMPLETED') {
                // Clear the session data only after successful capture
                Session::forget(['paypal_payment_id', 'plan_id', 'plan_amount']);

                // Create the order using CheckoutController
                $checkout = new CheckoutController;
                return $checkout->create_order($txn_id, 'paypal', $plan, $plan_amount, $request->coupon_id ,'success');
            } else {
                throw new \Exception($response['message'] ?? 'Payment capture failed.');
            }
        } catch (\Exception $e) {
            // Check if it's an "already captured" error
            if (strpos($e->getMessage(), 'ORDER_ALREADY_CAPTURED') !== false) {
                // Log the duplicate capture attempt
                \Log::warning('Duplicate PayPal capture attempt: ' . $txn_id);

                // Redirect to home with a more user-friendly message
                return redirect()->route('home.page')->with('info', 'Your payment has already been processed. If you have any concerns, please contact support.');
            }

            // Log other errors
            \Log::error('PayPal payment failed: ' . $e->getMessage());
            $coupon_id =$request->coupon_id;
            // Create a failed transaction record
            $this->create_failed_txn('paypal', $plan, $plan_amount,$coupon_id);

            // Redirect with an error message
            return redirect()->route('home.page')->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }
    //--------------------------- pay_success code end -----------------------

    //--------------------------- pay_cancel code start -----------------------
    public function paypal_cancel()
    {
        $txn_id = Session::get('paypal_payment_id');
        Session::forget(['paypal_payment_id','plan_id','plan_amount']);
        return redirect('/')->with('deleted', 'You have canceled the transaction.');;
    }
    //--------------------------- pay_cancel code end -----------------------

    //--------------------------- failed_tnx code start -----------------------
    protected function create_failed_txn($gateway, $plan_id, $amount,$coupon_id)
    {
        $checkout = new CheckoutController();
        $txn_id = 'failed_' . uniqid();

        return $checkout->create_order($txn_id, $gateway, $plan_id, $amount, $coupon_id, 'failed');
    }
    //--------------------------- failed_tnx code end -----------------------
}
