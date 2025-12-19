<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trustedslider extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'url',
        'status',
        'position'
    ];
}
