<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiSetting extends Model
{
    use HasFactory;
    protected $table = 'api_settings';
    protected $fillable = ['adsense_script','ad_status','analytics_script','an_status','recaptcha_status','aws_status','youtube_status','vimeo_status','gtm_status','mailchip_api_key','mailchip_id','fb_pixel','gpt_toggle','openapikey'];
}
