<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected $twilio;

    public function __construct()
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $this->twilio = new Client($sid, $token);
    }

    public function sendSMS($to, $message)
    {
        try {
            return $this->twilio->messages->create($to, [
                'from' => config('services.twilio.from'),
                'body' => $message
            ]);
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }
}
