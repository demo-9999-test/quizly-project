<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;

    protected $table = 'general_settings';
    protected $fillable = [
        'contact',
        'email',
        'support_email',
        'address',
        'iframe_url',
        'promo_text',
        'promo_link',
        'app_store_link',
        'play_store_link',
        'env_protection',
        'donation_link',
        'direct_link',
        'logo',
        'signup_img',
        'favicon_logo',
        'preloader_logo',
    ];

}
