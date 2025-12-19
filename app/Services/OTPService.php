<?php
namespace App\Services;

use Twilio\Rest\Client;
class OTPService
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
    }

    public function sendSms($to, $message)
    {
        $this->twilio->messages->create($to, [
            'MessagingServiceSid' => env('TWILIO_MESSAGING_SERVICE_SID'),
            'body' => $message,
        ]);
    }
}
