<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanguageSetting extends Model
{
    use HasFactory;
    protected $table = 'language_settings';
    protected $fillable = ['local', 'name', 'status','image'];
}
