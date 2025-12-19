<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zone extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'zones';
    protected $fillable = [
        'image', 'name', 'description'
    ];
}
