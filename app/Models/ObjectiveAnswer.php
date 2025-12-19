<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjectiveAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'quiz_id', 'question_id', 'user_answer', 'correct_answer','question_type' ,'answer_approved'];
    public function quiz()
    {
        return $this->belongsTo(Quiz::class)->withDefault();
    }

    public function question()
    {
        return $this->belongsTo(Objective::class, 'question_id')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function quizz()
    {
        return $this->belongsTo(Objective::class, 'quiz_id')->withDefault();
    }
}
