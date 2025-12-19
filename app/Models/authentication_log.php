<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class authentication_log extends Model
{
    use HasFactory;
    protected $table = 'authentication_log';

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function user()
    {
        return $this->belongsTo(User::class, 'authenticatable_id','id')->withDefault();
    }
}
