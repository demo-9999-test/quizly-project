<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coins;
use App\Models\User;
use Auth;
use Carbon\carbon;
use App\Models\GeneralSetting;

class CoinsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:coins.view', ['only' => ['index']]);
    }
    //----------------------- User coins code start -----------------------------
    public function user_coins($user_slug, Request $request) {
        $setting = GeneralSetting::first();
        $user = Auth::user();
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $transactionType = $request->input('transaction_type', 'all');


        // Base query
        $baseQuery = Coins::where('user_id', $user->id)
                          ->whereBetween('created_at', [$startDate, $endDate]);

        // Apply transaction type filter

        if ($transactionType === 'earnings') {
            $baseQuery->where('status', 'credited');
        } elseif ($transactionType === 'spendings') {
            $baseQuery->where('status', 'debited');
        }
        $total_earned = (clone $baseQuery)->where('status', 'credited')->sum('ammount');
        $total_spent = (clone $baseQuery)->where('status', 'debited')->sum('ammount');

        $transactions = $baseQuery->orderBy('created_at')->get();

        $balance = 0;
        $highest_balance = 0;

        foreach ($transactions as $transaction) {
            if ($transaction->status == 'credited') {
                $balance += $transaction->ammount;
            } else {
                $balance -= $transaction->ammount;
            }

            $highest_balance = max($highest_balance, $balance);

        }
        $chartStartDate = now()->startOfMonth()->format('Y-m-d');
        $chartEndDate = now()->endOfMonth()->format('Y-m-d');
        $allDates = collect(range(1, now()->daysInMonth()))->map(function($day) {
            return now()->startOfMonth()->addDays($day - 1)->format('Y-m-d');
        });


        $chartData = $allDates->mapWithKeys(function($date) use ($transactions) {
            $dailyBalance = 0;
            $dailyTransactions = $transactions->filter(function($transaction) use ($date) {
                return $transaction->created_at->format('Y-m-d') === $date;
            });
            foreach ($dailyTransactions as $transaction) {
                if ($transaction->status == 'credited') {
                    $dailyBalance += $transaction->ammount;
                } else {
                    $dailyBalance -= $transaction->ammount;
                }
            }
            return [$date => $dailyBalance];
        });


        $today = now()->format('Y-m-d');
        if (!$chartData->has($today)) {
            $chartData[$today] = $chartData->last(); // Use the last known balance for today
        }
        $categories = $allDates->map(function($date) {
            return Carbon::parse($date)->format('d'); // Just the day of the month
        });
        $balances = $chartData->values();

        $history = $baseQuery->orderBy('created_at','desc')->paginate(5);
        $credited_history = Coins::where('user_id', $user->id)->where('status','credited')->paginate(4);
        $debited_history = Coins::where('user_id', $user->id)->where('status','debited')->paginate(4);

        $coins = $baseQuery->orderBy('created_at','desc')->take(3)->get();

        return view('front.coins', compact(
            'setting', 'user', 'total_earned', 'total_spent', 'highest_balance',
            'history', 'credited_history', 'debited_history', 'startDate', 'endDate', 'transactionType',
            'categories', 'balances'
        ));
    }
    //----------------------- User coins code end -----------------------------

    //----------------------- coins transaction code start -----------------------------
    public function coins_transaction($user_id,$method,$status,$ammount) {
        $user = User::findOrFail($user_id);
        $coins = Coins::create([
            'user_id'  => $user->id,
            'method' => $method,
            'status' => $status,
            'ammount' => $ammount
        ]);
        if($status == 'credited') {
            $user->coins += $ammount;
            $user->save();
            $message = 'Coins have been credited successfully';
        }else if ($status == 'debited') {
            if($user->coins > 0){
                $user->coins -= $ammount;
                $user->save();
                $message = 'Coins have been debited successfully';
            }
        }else {
            $message = 'Something went wrong';
        }
        return ['success' => ($status == 'credited' || $status == 'debited'), 'message' => $message];
    }
    //----------------------- coins transaction code end -----------------------------
}

