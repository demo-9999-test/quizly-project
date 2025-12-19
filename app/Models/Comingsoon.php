<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comingsoon extends Model
{
    use HasFactory;

    protected $table = 'coming_soons';

    protected $fillable = [
        'heading',
        'btn_txt',
        'counter_one',
        'counter_two',
        'counter_three',
        'counter_four',
        'counter_one_txt',
        'counter_two_txt',
        'counter_three_txt',
        'counter_four_txt',
        'maintenance_mode',
        'image',
        'ip_address'
    ];
}
