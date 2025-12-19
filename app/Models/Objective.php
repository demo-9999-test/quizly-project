<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Objective extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "objectives";
    protected $fillable = [
        'question','option_a','option_b','option_c','option_d','correct_answer','quiz_id'
    ];
}
