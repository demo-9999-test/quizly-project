<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'header_title',
        'contact',
        'wp_msg',
        'wp_color',
        'button_position',
        'whatsapp_enable_button',
        'facebook_chat_bubble',
    ];
}
