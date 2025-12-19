<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateHistory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function refer_user(){

        return $this->belongsTo(User::class, 'refer_user_id', 'id')->withDefault();

    }

    public function user(){

        return $this->belongsTo(User::class);

    }
}
