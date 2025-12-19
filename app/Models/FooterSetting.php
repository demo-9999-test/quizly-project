<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    use HasFactory;
    protected $table = 'footer_settings';
    protected $fillable = ['title', 'image', 'fb_url','linkedin_url','twitter_url','insta_url','desc','copyright_text','footer_logo'];
}
