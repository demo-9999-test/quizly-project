<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Packages;
use App\Models\Coupon;
use App\Models\GeneralSetting;
use App\Models\PaymentSetting;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
class CheckoutController extends Controller
{
    //------------------- checkout front page code start --------------------------------
    public function index(string $id) {
        $setting = GeneralSetting::first();
        $plan = Packages::find($id);
        $coupons = Coupon::all();
        $paymentsetting = PaymentSetting::first();
        $appliedCoupon = null;

        if (request()->has('coupon')) {
            $appliedCoupon = Coupon::where('coupon_code', request('coupon'))->first();
        }

        return view('front.checkout_page', compact('setting', 'plan', 'coupons', 'paymentsetting', 'appliedCoupon'));
    }
    //------------------- checkout front page code end --------------------------------

    //------------------- create orders code start --------------------------------
    public function create_order($txn_id, $payment_method, $plan_id, $plan_amount,$coupon_id,$payment_status)
    {
        // Get authenticated user
        $user = Auth::user();
        if($user->role == 'A') {
            return redirect()->route('home.page')->with('success','You are admin');
        }
        // Find package by plan_id
        $package = Packages::findOrFail($plan_id);

        $currency = DB::table('currencies')->select('code', 'symbol')->where('default','1')->first();

        $order = Order::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'transaction_id' => $txn_id,
            'payment_method' => $payment_method,
            'total_amount' => $plan_amount,
            'coupon_discount' => $coupon_id !== null ? $coupon_id : null, // Explicitly handle null case
            'currency_name' => $currency->code,
            'currency_icon' => $currency->symbol,
            'status' => $payment_status,
        ]);
        if ($payment_status === 'success') {
            $coins = new CoinsController;
            $result = $coins->coins_transaction($user->id,'By using '.$payment_method, 'credited', $package->preward);
            if ($result['success']) {
                $message = $result['message'];
            } else {
                $message = 'Coin transaction failed: ' . $result['message'];
            }
        }

        else {
            $message = 'Payment failed. Please try again.';
        }
        return redirect()->route('front.coins', ['user_slug' => $user->slug])->with($payment_status, $message);
    }
    //------------------- create orders code start --------------------------------

    //------------------- admin orders table code start --------------------------------
    public function orders_table() {
        $order = Order::orderBy('created_at','desc')->paginate(10);
        return view('admin.orders.orders',compact('order'));
    }
    //------------------- admin orders table code end --------------------------------

    //------------------ apply coupon code start --------------------------------
    public function applyCoupon(Request $request)
    {
        $couponCode = $request->input('coupon_code');
        $planId = $request->input('plan_id');
        $coupon = Coupon::where('coupon_code', $couponCode)->first();
        $user = Auth::user()->id;
        $check = Order::where('user_id', $user)->count();

        if ($coupon) {
            if ($coupon->new_user && $check > 0) {
                return redirect()->route('checkout.index', ['id' => $planId])
                    ->with('error', 'Coupon is only valid for new users.');
            }

            if ($coupon->limit <= 0) {
                return redirect()->route('checkout.index', ['id' => $planId])
                    ->with('error', 'Coupon usage limit exceeded.');
            }

            $coupon->decrement('limit');
            $coupon->save();

            return redirect()->route('checkout.page', ['id' => $planId, 'coupon' => $couponCode])
                ->with('success', 'Coupon applied successfully');
        }

        return redirect()->route('checkout.index', ['id' => $planId])
            ->with('error', 'Invalid coupon code.');
    }
    //------------------ apply coupon code end --------------------------------

    //------------------ remove coupon code start --------------------------------
    public function removeCoupon(Request $request)
    {
        $planId = $request->input('plan_id');
        return redirect()->route('checkout.page', ['id' => $planId])
            ->with('success', 'Coupon removed successfully');
    }
    //------------------ remove coupon code end --------------------------------
}
