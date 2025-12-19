<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Auth;

class MidtransController extends Controller
{
    //---------------------------process code start-----------------------------------
    public function process(Request $request)
    {
        if(env('MIDTRANS_CLIENT_KEY') == '' || env('MIDTRANS_SERVER_KEY') == ''){
            return redirect('/')->with('error', "Midtrans Key Not Found Please Contact your Site Admin");
        }
        try {
            \Log::debug('Midtrans Server Key: ' . config('midtrans.server_key'));
            \Log::debug('Midtrans Client Key: ' . config('midtrans.client_key'));
            $serverKey = config('midtrans.server_key');
            if (empty($serverKey)) {
                throw new \Exception('Midtrans server key is not set');
            }

            Config::$serverKey = $serverKey;
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $user = Auth::user();
            $orderId = 'ORDER-' . time();
            $grossAmount = (int) round($request->plan_amount);
            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $grossAmount,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->mobile ?? '',
                ],
                'item_details' => [
                    [
                        'id' => $request->plan_id,
                        'price' => $grossAmount,
                        'quantity' => 1,
                        'name' => $request->pname ?? 'Plan Subscription',
                    ],
                ],
            ];

            $snapToken = Snap::getSnapToken($params);

            session([
                'midtrans_tnx_id' => $orderId,
                'midtrans_plan_id' => $request->plan_id,
                'midtrans_plan_amount' => $request->plan_amount
            ]);
            if(!$snapToken) {
                return response()->json([
                    'redirect_url' => route('midtrans.failed')
                ]);
            }

            return response()->json([
                'snap_token' => $snapToken,
                'redirect_url' => route('midtrans.success')
            ]);

        } catch (\Exception $e) {
            \Log::error('Midtrans payment processing error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function success(Request $request)
    {
        $checkout = new CheckoutController;
        $tnx_id = session('midtrans_tnx_id');
        $plan_id = session('midtrans_plan_id');
        $plan_amount = session('midtrans_plan_amount');
        $midtransResult = $request->all();

        session()->forget(['midtrans_tnx_id', 'midtrans_plan_id', 'midtrans_plan_amount']);
        return $checkout->create_order($tnx_id, 'Midtrans', $plan_id, $plan_amount, $request->coupon_id,'success');
    }
    //---------------------------process code end-----------------------------------

    //---------------------------failed code start-----------------------------------
    public function failed(Request $request)
    {
        $checkout = new CheckoutController;
        $tnx_id = session('midtrans_tnx_id');
        $plan_id = session('midtrans_plan_id');
        $plan_amount = session('midtrans_plan_amount');
        $midtransResult = $request->all();

        \Log::error('Midtrans payment failed', [
            'transaction_id' => $tnx_id,
            'plan_id' => $plan_id,
            'amount' => $plan_amount,
            'midtrans_result' => $midtransResult
        ]);

        session()->forget(['midtrans_tnx_id', 'midtrans_plan_id', 'midtrans_plan_amount']);

        return $checkout->create_order($tnx_id, 'Midtrans', $plan_id, $plan_amount, $request->coupon_id,'failed');
    }
    //---------------------------failed code end-----------------------------------
}
