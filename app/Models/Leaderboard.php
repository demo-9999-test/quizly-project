<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leaderboard extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'total_score'];
    protected $touches = ['user'];
    protected static function booted()
    {
        static::saved(function ($leaderboard) {
            static::updateRanks();
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
    public static function updateRanks()
    {
        $leaderboard = static::orderBy('total_score', 'desc')
                            ->orderBy('updated_at', 'desc')
                            ->get();

        $rank = 1;

        foreach ($leaderboard as $entry) {
            if ($entry->user->rank != $rank) {
                $entry->user->rank = $rank;
                $entry->user->save();
            }
            $rank++;
        }
    }
}
