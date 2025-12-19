<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsSetting extends Model
{
    use HasFactory;
    protected $table = 'sms_settings';
    protected $fillable = [
    'twilio_sid',
    'twilio_auth_token',
    'twilio_number',
    'twillio_enable',
    'mimsms_enable',
    'exabytes_enable',
    'msg_enable',
    'bulksms_enable',
    'clicktail_enable'
];
}
