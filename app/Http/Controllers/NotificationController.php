<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralSetting;

class NotificationController extends Controller
{
    //--------------------------- index code start -----------------------
    public function index()
    {
        $setting = GeneralSetting::first();
        $notification = auth()->user()->unreadNotifications;
        return view('front.notification', compact('notification','setting'));
    }
    //--------------------------- index code end -----------------------

    //--------------------------- delete notification code start -----------------------
    public function deleteNotification($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->delete();

        return redirect()->back()->with('success', 'Notification deleted successfully.');
    }
    //--------------------------- delete notification code end -----------------------
}
