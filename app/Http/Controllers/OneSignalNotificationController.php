<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use App\Notifications\OfferPushNotifications;
use Laracasts\Flash\Flash;

class OneSignalNotificationController extends Controller
{
    //--------------------------- index code start -----------------------
    public function index()
    {
        return view('admin.push-notification.index');
    }
    //--------------------------- index code end -----------------------

    //--------------------------- push code start -----------------------
    public function push(Request $request)
    {
        ini_set('max_execution_time', -1);
        ini_set('memory_limit', -1);

        $request->validate([
            'subject' => 'required|string',
            'message' => 'required'
        ]);

        if (empty(env('ONESIGNAL_APP_ID')) || empty(env('ONESIGNAL_REST_API_KEY'))) {
            Flash::error('Please update OneSignal keys in settings!');
            return back()->withInput();
        }
        try {
            $usergroup = User::query();

            $data = [
                'subject' => $request->subject,
                'body' => $request->message,
                'target_url' => $request->target_url ?? null,
                'icon' => $request->icon ?? null,
                'image' => $request->image ?? null,
                'buttonChecked' => $request->show_button ? "yes" : "no",
                'button_text' => $request->btn_text ?? null,
                'button_url' => $request->btn_url ?? null,
            ];

            if ($request->user_group == 'all_customers') {
                $users = $usergroup->select('id')->where('role', '=', 'U')->get();

            } elseif ($request->user_group == 'all_admins') {
                $users = $usergroup->select('id')->where('role', '=', 'A')->get();
            } else {
                $users = $usergroup->get(['id']);
            }
            $users = $usergroup->select('id')->get();

            Log::info('Sending notification to users:', $users->pluck('id')->toArray());

            Notification::send($users, new OfferPushNotifications($data));

            Flash::success('Notification pushed successfully!');
            return back();

        } catch (\Exception $e) {
            Log::error('Failed to push notification: ' . $e->getMessage());
            Flash::error('Failed to push notification: ' . $e->getMessage());
            return back()->withInput();
        }
    }
    //--------------------------- push code end -----------------------

    //--------------------------- updatekeys code start -----------------------
    public function updateKeys(Request $request)
    {
        $request->validate([
            'ONESIGNAL_APP_ID' => 'required|string',
            'ONESIGNAL_REST_API_KEY' => 'required|string'
        ]);

        try {
            $envFile = base_path('.env');
            $contents = file_get_contents($envFile);

            $contents = str_replace(
                'ONESIGNAL_APP_ID=' . env('ONESIGNAL_APP_ID'),
                'ONESIGNAL_APP_ID=' . $request->ONESIGNAL_APP_ID,
                $contents
            );
            $contents = str_replace(
                'ONESIGNAL_REST_API_KEY=' . env('ONESIGNAL_REST_API_KEY'),
                'ONESIGNAL_REST_API_KEY=' . $request->ONESIGNAL_REST_API_KEY,
                $contents
            );

            file_put_contents($envFile, $contents);

            return redirect()->back()->with('success', 'OneSignal keys updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update OneSignal keys: ' . $e->getMessage());
        }
    }
    //--------------------------- updatekeys code end -----------------------
}
