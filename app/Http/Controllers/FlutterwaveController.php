<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class FlutterwaveController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }
    //------------------------- initialize payment code start -------------------------------
    public function initializePayment(Request $request)
    {
        try {
            $planId = $request->input('plan_id');
            $planAmount = $request->input('plan_amount');

            if (!$planId || !$planAmount) {
                throw new \Exception('Plan ID or amount is missing');
            }
            $response = $this->client->post('https://api.flutterwave.com/v3/payments', [
                'headers' => [
                    'Authorization' =>'Bearer ' . substr(config('services.flutterwave.secret_key'), 0, 5) . '...',
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'tx_ref' => uniqid('fw_', true),
                    'amount' => $planAmount,
                    'currency' => 'NGN',
                    'redirect_url' => route('flutterwave.callback'),
                    'meta' => [
                        'plan_id' => $planId,
                    ],
                    'customer' => [
                        'email' => $request->input('email'),
                        'name' => $request->input('name'),
                    ],
                ],
            ]);
            $responseData = json_decode($response->getBody(), true);
            if (isset($responseData['data']['link'])) {
                return redirect($responseData['data']['link']);
            }

            throw new \Exception('Payment link not found in response');
        } catch (\Exception $e) {
            \Log::error('Flutterwave API Error: ' . $e->getMessage());
            \Log::error('Response Body: ' . $e->getTraceAsString());

            return redirect()->back()->with('error', 'An error occurred while processing your payment. Please try again.');
        }
    }
    //------------------------- initialize payment code end -------------------------------

    //------------------------- callback handling code start -------------------------------
    public function handlePaymentCallback(Request $request)
    {
        if ($request->filled(['status', 'transaction_id']) && $request->status === 'successful') {
            // Verify the transaction with Flutterwave
            $verificationResult = $this->verifyTransaction($request->transaction_id);

            if ($verificationResult) {
                $planId = $verificationResult['meta']['plan_id'] ?? null;
                $planAmount = $verificationResult['amount'];
                $txRef = $verificationResult['tx_ref'];
                $currency = $verificationResult['currency'];

                // Instantiate CheckoutController and call createorder method
                $checkout = new CheckoutController;
                return $checkout->create_order($request->transaction_id, 'flutterwave', $planId, $planAmount,$request->coupon_id, 'success');
            }
        }

        return redirect('/')->with('error', 'Payment failed or not verified.');
    }
    //------------------------- callback handling code end -------------------------------

    //------------------------- verify transaction code start -------------------------------
    private function verifyTransaction($transactionId)
    {
        try {
            $response = $this->client->get("https://api.flutterwave.com/v3/transactions/{$transactionId}/verify", [
                'headers' => [
                    'Authorization' => 'Bearer ' . config('services.flutterwave.secret_key'),
                    'Content-Type' => 'application/json',
                ],
            ]);

            $responseData = json_decode($response->getBody(), true);

            if (isset($responseData['status']) && $responseData['status'] === 'success') {
                return $responseData['data'];
            }

            return false;
        } catch (\Exception $e) {
            \Log::error('Flutterwave Transaction Verification Error: ' . $e->getMessage());
            return false;
        }
    }
    //------------------------- verify transaction code end -------------------------------

}
