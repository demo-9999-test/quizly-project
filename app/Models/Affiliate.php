<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    use HasFactory;
    protected $fillable = [
        'ref_length',
        'point_per_referral',
        'affiliate_minimum_withdrawal',
        'title',
        'sub_title',
        'desc',
        'status'
    ];
}
