<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function downloadQuizReport($quiz_id, $user_id)
    {
        return "Quiz ID: $quiz_id, User ID: $user_id";
    }
}
