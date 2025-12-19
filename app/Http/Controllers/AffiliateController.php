<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Affiliate;
use App\Models\AffiliateHistory;
use App\Models\User;
use App\Models\PaymentRequest;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\DB;

class AffiliateController extends Controller
{
    // Constructor to apply middleware for permission checks
    public function __construct()
    {
        $this->middleware('permission:affiliate.manage', ['only' => [
            'index', 'update', 'getlink', 'generatelink', 'history', 'payment_request',
            'payment_request_create', 'payment_request_store', 'payment_edit', 'payment_request_update'
        ]]);
    }

    // Display affiliate settings
    public function index()
    {
        $affiliates = Affiliate::first(); // Get the first affiliate settings record
        return view('admin.affiliate.index', compact('affiliates'));
    }

    // Update or create affiliate settings
    public function update(Request $request)
    {
        try {
            $affiliates = Affiliate::first(); // Get the first affiliate settings record

            // Gather input data
            $input = $request->all();
            $input['point_per_referral'] = $request->point_per_referral;
            $input['ref_length'] = $request->ref_length;
            $input['affiliate_minimum_withdrawal'] = $request->affiliate_minimum_withdrawal;
            $input['title'] = $request->title;
            $input['sub_title'] = $request->sub_title;
            $input['desc'] = $request->desc;
            $input['status'] = $request->has('status') ? 1 : 0;

            if ($affiliates) {
                $affiliates->update($input); // Update existing record
            } else {
                Affiliate::create($input); // Create new record if none exists
            }

            return back()->with('success','Updated successfully');
        } catch (\Exception $e) {
            $errorMessage = 'An error occurred while updating settings: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }

    // Display affiliate referral link
    public function getlink()
    {
        $affiliates = Affiliate::first();
        return view('admin.affiliate.show', compact('affiliates'));
    }

    // Generate a new referral link for the authenticated user
    public function generatelink()
    {
        $referCode = User::createReferCode(); // Generate a new referral code
        Auth::user()->update(['affiliate_id' => $referCode]); // Update user's affiliate ID
        return view('admin.affiliate.show');
    }

    // Display the affiliate history of the authenticated user
    public function history()
    {
        $userId = Auth::id(); // Get the currently authenticated user ID

        // Fetch affiliate history
        $history = AffiliateHistory::where('user_id', $userId)->get();

        // Calculate total referral amount and total amount paid
        $totalAmount = $history->sum('amount');
        $totalPaid = PaymentRequest::where('user_id', $userId)->sum('amount');

        // Calculate remaining amount
        $remainingAmount = $totalAmount - $totalPaid;

        return view('admin.affiliate.history', compact('history', 'totalAmount', 'totalPaid', 'remainingAmount'));
    }

    // Display payment requests based on user role
    public function payment_request()
    {
        $query = Auth::user()->role === 'A' ? PaymentRequest::query() : PaymentRequest::where('user_id', Auth::id());
        $pay_reqs = $query->paginate(10); // Paginate payment requests
        return view('admin.affiliate.user_payment_request.index', compact('pay_reqs'));
    }

    // Show the form for creating a new payment request
    public function payment_request_create()
    {
        $userId = Auth::id();

        // Calculate the total referral amount available for withdrawal
        $totalReferralAmount = AffiliateHistory::where('user_id', $userId)
            ->whereColumn('amount', '>', 'paid_amount')
            ->sum(DB::raw('amount - paid_amount'));

        return view('admin.affiliate.user_payment_request.create', compact('totalReferralAmount'));
    }

    // Store a new payment request
    public function payment_request_store(Request $request)
    {
        try{
            $request->validate([
                "bank_details" => "required|string|max:255",
                "amount" => "required|numeric|min:0",
            ]);

            $user = Auth::user();

            // Calculate the total amount that can still be requested
            $totalAvailableAmount = AffiliateHistory::where('user_id', $user->id)
                ->whereColumn('amount', '>', 'paid_amount')
                ->sum(DB::raw('amount - paid_amount'));

            if ($request->amount > $totalAvailableAmount) {
                return redirect()->back()->with('error','You cannot request more than the available referral amount.');
            }

            // Check for an existing pending payment request
            if (PaymentRequest::where('user_id', $user->id)->where('status', 'Pending')->exists()) {
                return redirect()->back()->with('error','You have an existing pending payment request.');
            }

            // Create a new payment request
            PaymentRequest::create([
                'bank_details' => $request->bank_details,
                'amount' => $request->amount,
                'user_id' => $user->id,
                'status' => 'Pending'
            ]);
            return redirect('admin/payment/request')->with('success','Payment request has been submitted successfully.');
        } catch (\Exception $e) {
            $errorMessage = 'An error occurred while updating settings: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    // Show the form for editing a payment request
    public function payment_edit($id)
    {
        $payment = PaymentRequest::findOrFail($id); // Find the payment request by ID
        return view('admin.affiliate.user_payment_request.edit', compact('payment'));
    }

    // Update a payment request to 'Paid' status
    public function payment_request_update(Request $request)
    {
        try{
            $request->validate([
                "amount" => "required|numeric|min:1",
                "payment_request_id" => "required|exists:payment_requests,id"
            ]);

            DB::beginTransaction();
            try {
                $paymentRequest = PaymentRequest::findOrFail($request->payment_request_id);

                if ($paymentRequest->status === 'Paid') {
                    throw new \Exception('This payment request has already been paid.');
                }

                $paymentRequest->update([
                    'status' => 'Paid',
                    'amount' => $request->amount, // ✅ overwrite amount value
                ]);

                Payment::create([
                    'payment_request_id' => $paymentRequest->id,
                    'user_id' => $paymentRequest->user_id,
                    'amount' => $request->amount
                ]);

                // Fetch all relevant affiliate history records
                $affiliateHistories = AffiliateHistory::where('user_id', $paymentRequest->user_id)
                    ->whereColumn('paid_amount', '<', 'amount')
                    ->orderBy('created_at')
                    ->get();

                // Process the payment
                $this->processPayment($affiliateHistories, $request->amount);

                DB::commit();
                Flash::success('Payment processed successfully.')->important();
            } catch (\Exception $e) {
                DB::rollBack();
                Flash::error($e->getMessage())->important(); // Handle exceptions
            }

            return redirect('admin/payment/request')->with('success','Request done successfully');

        } catch (\Exception $e) {
            $errorMessage = 'An error occurred while updating settings: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }

    // Private method to process payment across affiliate history records
    private function processPayment($affiliateHistories, $requestedAmount)
    {
        $remainingAmount = $requestedAmount;

        foreach ($affiliateHistories as $history) {
            if ($remainingAmount <= 0) break;

            // Calculate the remaining amount that can be paid against this history entry
            $availableToPay = $history->amount - $history->paid_amount;
            $payableAmount = min($availableToPay, $remainingAmount);

            // Add the payable amount to the paid_amount column
            $history->paid_amount += $payableAmount;

            // Ensure the paid_amount does not exceed the original amount
            if ($history->paid_amount >= $history->amount) {
                $history->paid_amount = $history->amount;
            }

            $history->save();

            // Subtract the paid amount from the remaining amount
            $remainingAmount -= $payableAmount;
        }

        // Optional: Handle cases where payment couldn't cover all affiliate histories
        if ($remainingAmount > 0) {
            // Additional logic can be implemented here if needed
        }
    }
}
