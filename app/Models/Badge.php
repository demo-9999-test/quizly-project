<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Badge extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'badges';
    protected $fillable = [
        'image', 'name', 'description','score','status'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'assign_badges');
    }
}
