<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Illuminate\Support\Facades\Mail;
use App\Models\Setting;
use App\Mail\TestMail;
use Laracasts\Flash\Flash;

class MailSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:mail.manage', ['only' => ['index','store','show']]);
    }
    //---------------------------------- Page View Code start-------------------------------
    public function index()
    {
        return view('admin.project-settings.mail-setting');
    }
 //---------------------------------- Page View Code end-------------------------------

 //---------------------------------- Data Store Code start-------------------------------

 public function store(Request $request)
{
    if (config('app.demolock') == 1) {
        return back()->with('error', 'Demo mode is enabled. Data cannot be updated.');
    }
    // Validate the request data
    $request->validate([
        'MAIL_HOST' => 'required',
        'MAIL_PORT' => 'required',
        'MAIL_FROM_ADDRESS' => 'required',
        'MAIL_USERNAME' => 'required',
        'MAIL_PASSWORD' => 'required',
    ]);
    try {
        $setting = Setting::firstOrNew();
        $setting->welcome_status = $request->input('welcome_status') ? 1 : 0;
        $setting->verify_status = $request->input('verify_status') ? 1 : 0;
        $setting->save();
        DotenvEditor::setKeys([
            'MAIL_FROM_NAME' => $request->MAIL_FROM_NAME,
            'MAIL_MAILER' => $request->MAIL_MAILER,
            'MAIL_HOST' => $request->MAIL_HOST,
            'MAIL_PORT' => $request->MAIL_PORT,
            'MAIL_FROM_ADDRESS' => $request->MAIL_FROM_ADDRESS,
            'MAIL_USERNAME' => $request->MAIL_USERNAME,
            'MAIL_PASSWORD' => $request->MAIL_PASSWORD,
            'MAIL_ENCRYPTION' => $request->MAIL_ENCRYPTION,
        ])->save();
        \Artisan::call('config:clear');
        \Artisan::call('cache:clear');
        \Artisan::call('config:cache');

        return redirect('admin/mail-setting')->with('success','Data has been updated.');
    } catch (\Exception $e) {
        return back()->with('error','An error occurred while updating the data. Please try again.');
    }
}

//---------------------------------- Data Store Code end-------------------------------

//---------------------------------- All Data Show Code start-------------------------------
public function show(Request $request)
{
    $mailFromName    = config('mail.from.name');
    $mailMailer      = config('mail.default');
    $mailHost        = config('mail.mailers.smtp.host');
    $mailPort        = config('mail.mailers.smtp.port');
    $mailFromAddress = config('mail.from.address');
    $mailUsername    = config('mail.mailers.smtp.username');
    $mailPassword    = config('mail.mailers.smtp.password');
    $mailEncryption  = config('mail.mailers.smtp.encryption');
    $settings        = Setting::first();

    return view('admin.project-settings.mail-setting', compact(
        'mailFromName',
        'mailMailer',
        'mailHost',
        'mailPort',
        'mailFromAddress',
        'mailUsername',
        'mailPassword',
        'mailEncryption',
        'settings'
    ));
}

public function sendEmail(Request $request)
{
    $testEmail = $request->input('sender_email');
    try {
        Mail::to($testEmail)->send(new TestMail());
        Flash::success('Email sent successfully.');
        return back();
    } catch (\Exception $e) {
        Flash::error('An error occurred while sending the email. Please try again.');
        return back();
    }
}
//---------------------------------- All Data Show Code end-------------------------------
}
