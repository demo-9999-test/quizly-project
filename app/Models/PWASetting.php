<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PWASetting extends Model
{
    use HasFactory;
    protected $table = 'p_w_a_settings';
    protected $fillable = [
        'pwa_icon',
        'pwa_splash_icon',
    ];
}
