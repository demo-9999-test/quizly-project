<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialSetting extends Model
{
    use HasFactory;
    protected $table = 'social_settings';
    protected $fillable = [
        'facebook_status',
        'google_status',
        'gitlab_status',
        'amazon_status',
        'linkedin_status',
        'github_status',
    ];
}
