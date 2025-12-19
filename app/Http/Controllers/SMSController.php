<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SmsSetting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class SMSController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:sms.manage', ['only' => [
            'index',
            'twiliostore',
            'verifyPassword'
        ]]);
    }

    public function index()
{
    $sms = SmsSetting::first();

    $env = DotenvEditor::getKeys([
        'TWILIO_SID',
        'TWILIO_AUTH_TOKEN',
        'TWILIO_NUMBER',
    ]);

    return view('admin.sms.index', [
        'twilio_sid' => $env['TWILIO_SID']['value'] ?? '',
        'twilio_auth_token' => $env['TWILIO_AUTH_TOKEN']['value'] ?? '',
        'twilio_number' => $env['TWILIO_NUMBER']['value'] ?? '',
        'settings' => $sms
    ]);
}


public function twiliostore(Request $request)
{
    \Log::info('Form input', $request->all());

    try {
        if (config('app.demolock') == 1) {
            return back()->with('error', 'Disabled in Demo lock');
        }

        $request->validate([
            'twilio_sid' => 'required|string',
            'twilio_auth_token' => 'required|string',
            'twilio_number' => 'required|string',
        ]);

        DotenvEditor::setKeys([
            'TWILIO_SID' => $request->twilio_sid,
            'TWILIO_AUTH_TOKEN' => $request->twilio_auth_token,
            'TWILIO_NUMBER' => $request->twilio_number,
        ])->save();

        Artisan::call('config:clear');

        $settings = SmsSetting::firstOrNew();
        $settings->twillio_enable = $request->has('twillio_enable') ? 1 : 0;
        $settings->save();

        return redirect()->route('sms.index')->with('success', 'Twilio SMS settings updated successfully.');

    } catch (\Exception $e) {
        \Log::error('Twilio Update Failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        return back()->with('error', 'An unexpected error occurred.')->withInput();
    }
}


    public function verifyPassword(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required|string',
            ]);

            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated.'
                ], 401);
            }

            if (Hash::check($request->password, $user->password)) {
                return response()->json(['success' => true]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Incorrect password.'
                ], 401);
            }
        } catch (\Exception $e) {
            Log::error('verifyPassword failed', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Server error. Try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
