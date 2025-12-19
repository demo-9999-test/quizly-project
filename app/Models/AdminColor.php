<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminColor extends Model
{
    use HasFactory;
    protected $table = 'admin_colors';
    protected $fillable = [
        'bg_light_grey',
        'bg_white',
        'bg_dark_blue',
        'bg_dark_grey',
        'bg_black',
        'bg_yellow',
        'text_black',
        'text_dark_grey',
        'text_light_grey',
        'text_dark_blue',
        'text_white',
        'text_red',
        'text_yellow',
        'border_white',
        'border_black',
        'border_light_grey',
        'border_dark_grey',
        'border_grey',
        'border_dark_blue',
        'border_yellow',
    ];
}
