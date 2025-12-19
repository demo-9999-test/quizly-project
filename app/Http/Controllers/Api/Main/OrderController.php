<?php

namespace App\Http\Controllers\Api\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Packages;
use App\Models\Order;
use App\Http\Controllers\Api\CoinsController;
use Illuminate\Support\Facades\DB;
use App\Models\Coins;
use App\Models\User;
use App\Models\InvoiceSettings;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
public function createOrderApi(Request $request)
{
    $request->validate([
        'txn_id'         => 'required|string',
        'payment_method' => 'required|string',
        'plan_id'        => 'required|exists:packages,id',
        'plan_amount'    => 'required|numeric',
        'coupon_id'      => 'nullable|string',
        'payment_status' => 'required|in:success,failed',
    ]);

    $user = Auth::user();
    if ($user->role === 'A') {
        return response()->json([
            'status' => false,
            'message' => 'Admins cannot make orders.',
        ], 403);
    }

    $package = Packages::findOrFail($request->plan_id);

    $currency = DB::table('currencies')->select('code', 'symbol')->where('default', '1')->first();

    $order = Order::create([
        'user_id'         => $user->id,
        'package_id'      => $package->id,
        'transaction_id'  => $request->txn_id,
        'payment_method'  => $request->payment_method,
        'total_amount'    => $request->plan_amount,
        'coupon_discount' => $request->coupon_id ?? null,
        'currency_name'   => $currency->code ?? 'USD',
        'currency_icon'   => $currency->symbol ?? '$',
        'status'          => $request->payment_status,
    ]);

    if ($request->payment_status === 'success') {
        // Inline coins_transaction function logic
        $coinsResult = $this->coins_transaction($user->id, 'By using ' . $request->payment_method, 'credited', $package->preward);

        if ($coinsResult['success']) {
            return response()->json([
                'status' => true,
                'message' => $coinsResult['message'],
                'order_id' => $order->id
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Coin transaction failed: ' . $coinsResult['message'],
                'order_id' => $order->id
            ], 500);
        }
    }

    return response()->json([
        'status' => false,
        'message' => 'Payment failed. Please try again.',
        'order_id' => $order->id
    ], 400);
}

public function coins_transaction($user_id, $method, $status, $ammount)
{
    $user = User::findOrFail($user_id);

    Coins::create([
        'user_id' => $user->id,
        'method'  => $method,
        'status'  => $status,
        'ammount' => $ammount
    ]);

    if ($status === 'credited') {
        $user->coins += $ammount;
        $user->save();
        $message = 'Coins have been credited successfully';
    } elseif ($status === 'debited') {
        if ($user->coins >= $ammount) {
            $user->coins -= $ammount;
            $user->save();
            $message = 'Coins have been debited successfully';
        } else {
            return ['success' => false, 'message' => 'Not enough coins to debit'];
        }
    } else {
        return ['success' => false, 'message' => 'Invalid transaction status'];
    }

    return ['success' => true, 'message' => $message];
}
public function userOrders(){
    $orders = Order::where('user_id', Auth::id())
        ->with(['package', 'user'])
        ->orderBy('created_at', 'desc')
        ->get();
    return response()->json([
        'status' => true,
        'message' => 'User orders retrieved successfully',
        'data' => $orders
    ], 200);
}
public function invoice(Request $request)
{
    $user_slug = Auth::user()->slug;
    $transaction_id = request()->route('transaction_id');
    $user = User::where('slug', $user_slug)->firstOrFail();

    // Authorization check
    if (Auth::id() !== $user->id) {
        return response()->json([
            'status' => false,
            'message' => 'Unauthorized action.'
        ], 403);
    }

    $transaction = Order::where('transaction_id', $transaction_id)
                        ->where('user_id', $user->id)
                        ->firstOrFail();

    $invoice = InvoiceSettings::first();

    $pdf = Pdf::loadView('front.pdfs.invoice_pdf', compact('user', 'transaction', 'invoice'));

    // Return PDF as file response
    return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="invoice_' . $transaction_id . '.pdf"');
}

}
