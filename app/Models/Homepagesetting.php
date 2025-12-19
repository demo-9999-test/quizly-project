<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homepagesetting extends Model
{
    use HasFactory;
    protected $table = 'homepage_settings';
    protected $fillable = [
        'slider',
        'counter',
        'categories',
        'friends',
        'discover_quiz',
        'battle',
        'zone',
        'testimonial',
        'blogs',
        'newsletter',
    ];
}
