<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\authentication_log;

class ActivityLogController extends Controller
{
    //------------------------- Activity log index code start -------------------------
    function index() {
        $authentication_logs = authentication_log::all();
        return view('admin.activity-log.index',compact('authentication_logs'));
    }
    //------------------------- Activity log index code end -------------------------

}
