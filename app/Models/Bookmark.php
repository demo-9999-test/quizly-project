<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'quiz_id'];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class)->withDefault();
    }
}
