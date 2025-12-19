<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Battle extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'battles';
    protected $fillable = [
        'image', 'name', 'slug','room_time', 'description','status'
    ];
}
