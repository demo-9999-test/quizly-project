<?php // Code within app\Helpers\Helper.php

use App\Models\FavoritePost;
use Illuminate\Support\Facades\Auth;
use Torann\Currency\Facades\Currency;
use GuzzleHttp\Client;

function changeCurrency()
{
    return Currency::convert()->from('GBP')->to('NGN')->amount(150)->get();
}

function currencyConverter($fromCurrency, $toCurrency, $amount)
    {
        $apiKey = "{{ env('OPEN_EXCHANGE_RATE_KEY') }}";
        $apiEndpoint = "https://open.er-api.com/v6/latest";
        $client = new Client();
        try {
            $response = $client->get($apiEndpoint, [
                'query' => [
                    'api_key' => $apiKey,
                ],
            ]);
            $data = json_decode($response->getBody(), true);
            $exchangeRate = $data['rates'][$toCurrency] / $data['rates'][$fromCurrency];
            $convertedAmount = $amount * $exchangeRate;
            return round($convertedAmount, 2);
        } catch (\Exception $e) {
            // Handle the exception (e.g., log, return default value, etc.)
            return $amount;
        }
    }

