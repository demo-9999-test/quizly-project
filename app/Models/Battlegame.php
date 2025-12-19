<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Battlegame extends Model
{
    use HasFactory;
    protected $fillable = [
        'creator_id',
        'opponent_id',
        'quiz_id',
        'battle_id',
        'room_name',
        'bid_amount',
        'code',
        'expires_at',
        'creator_completed',
        'opponent_completed',
        'status'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id')->withDefault();
    }

    public function opponent()
    {
        return $this->belongsTo(User::class, 'opponent_id')->withDefault();
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }
}
