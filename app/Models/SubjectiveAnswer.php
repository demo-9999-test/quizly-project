<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectiveAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'quiz_id', 'question_id', 'answer','answer_approved'];
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function question()
    {
        return $this->belongsTo(Subjective::class, 'question_id')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function quizz()
    {
        return $this->belongsTo(Subjective::class)->withDefault();
    }
}
