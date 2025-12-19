<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContestController extends Controller
{
    public function contest_page()
    {
        return 'Contest Page';
    }

    public function contest_single($slug)
    {
        return 'Contest: ' . $slug;
    }
}
