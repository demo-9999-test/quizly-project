<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use App\Models\ApiSetting;
use Laracasts\Flash\Flash;
use App\Http\Controllers\Controller; // Import the base Controller

class ApiSettingController extends Controller
{
    // Middleware to ensure the user has permission for API settings management
    public function __construct()
    {
        $this->middleware('permission:apisetting.manage', ['only' => [
            'apisetting', 'facebookstore', 'adsensestore', 'analyticsstore',
            'recaptcha', 'aws', 'youtube', 'vimeo', 'gtm', 'openapikey'
        ]]);
    }

    // Display API settings and environment variables
    public function apisetting()
    {
        $env_files = [
            'RECAPTCHA_SITE_KEY' => env('RECAPTCHA_SITE_KEY'),
            'RECAPTCHA_SECRET_KEY' => env('RECAPTCHA_SECRET_KEY'),
            'AWS_ACCESS_KEY_ID' => decrypt(env('AWS_ACCESS_KEY_ID')),
            'AWS_SECRET_ACCESS_KEY' => decrypt(env('AWS_SECRET_ACCESS_KEY')),
            'AWS_DEFAULT_REGION' => env('AWS_DEFAULT_REGION'),
            'AWS_BUCKET' => env('AWS_BUCKET'),
            'AWS_URL' => env('AWS_URL'),
            'YOUTUBE_API_KEY' => decrypt(env('YOUTUBE_API_KEY')),
            'VIMEO_CLIENT' => decrypt(env('VIMEO_CLIENT')),
            'VIMEO_ACCESS' => decrypt(env('VIMEO_ACCESS')),
            'VIMEO_SECRET' => decrypt(env('VIMEO_SECRET')),
            'GOOGLE_TAG_MANAGER_ID' => decrypt(env('GOOGLE_TAG_MANAGER_ID')),
        ];

        $settings = ApiSetting::first(); // Fetch existing API settings
        $mailchipapikey = Crypt::decrypt($settings->mailchip_api_key); // Decrypt Mailchimp API key
        $fb_pixel = Crypt::decrypt($settings->fb_pixel); // Decrypt Facebook Pixel ID
        $openapikey = $settings->openapikey; // Get OpenAI API key

        return view('admin.api-setting.index', compact('settings', 'env_files', 'mailchipapikey', 'fb_pixel', 'openapikey'));
    }

    // Update Facebook Pixel ID
    public function facebookstore(Request $request)
    {
        if(config('app.demolock') == 1){
            return back()->with('error','Disabled in demo'); // Return error if demo mode is enabled
        }

        $settings = ApiSetting::firstOrNew(); // Get or create a new setting record
        $settings->fb_pixel = encrypt($request->input('fb_pixel')); // Encrypt and store Facebook Pixel ID
        $settings->save();

        return redirect('admin/api-setting')->with('success','Data has been updated.');
    }

    // Update Google AdSense settings
    public function adsensestore(Request $request)
    {
        if(config('app.demolock') == 1){
            return back()->with('error','Disabled in demo'); // Return error if demo mode is enabled
        }

        $request->validate([
            'adsense_script' => 'required', // Validate AdSense script is provided
        ]);

        $adsense = ApiSetting::firstOrNew();
        $adsense->adsense_script = $request->input('adsense_script');
        $adsense->ad_status = $request->input('ad_status') ? 1 : 0;
        $adsense->save();

        return redirect('admin/api-setting')->with('success','Data has been updated.');
    }

    // Update Google Analytics settings
    public function analyticsstore(Request $request)
    {
        if(config('app.demolock') == 1){
            return back()->with('error','Disabled in demo'); // Return error if demo mode is enabled
        }

        $request->validate([
            'analytics_script' => 'required', // Validate Analytics script is provided
        ]);

        $analytics = ApiSetting::firstOrNew();
        $analytics->analytics_script = $request->input('analytics_script');
        $analytics->an_status = $request->input('an_status') ? 1 : 0;
        $analytics->save();

        return redirect('admin/api-setting')->with('success','Data has been updated.');
    }

    // Update reCAPTCHA settings
    public function recaptcha(Request $request)
    {
        if(config('app.demolock') == 1){
            return back()->with('error','Disabled in demo');
        }

        $request->validate([
            'RECAPTCHA_SITE_KEY' => 'required',
            'RECAPTCHA_SECRET_KEY' => 'required',
        ]);

        // Save to .env using DotenvEditor
        $env_update = DotenvEditor::setKeys([
            'RECAPTCHA_SITE_KEY' => $request->input('RECAPTCHA_SITE_KEY'),
            'RECAPTCHA_SECRET_KEY' => $request->input('RECAPTCHA_SECRET_KEY'),
        ]);
        $env_update->save(); // ✅ Now $env_update is defined

        // Update DB status
        $setting = ApiSetting::firstOrNew();
        $setting->recaptcha_status = $request->input('recaptcha_status') ? 1 : 0;
        $setting->save();

        return redirect('admin/api-setting')->with('success','Data has been updated.');
    }


    // Update AWS settings
    public function aws(Request $request)
    {
        if(config('app.demolock') == 1){
            return back()->with('error','Disabled in demo'); // Return error if demo mode is enabled
        }

        $request->validate([
            'AWS_ACCESS_KEY_ID' => 'required',
            'AWS_SECRET_ACCESS_KEY' => 'required',
            'AWS_DEFAULT_REGION' => 'required',
            'AWS_BUCKET' => 'required',
            'AWS_URL' => 'required',
        ]);

        $encryptedAccessKey = encrypt($request->input('AWS_ACCESS_KEY_ID'));
        $encryptedSecretKey = encrypt($request->input('AWS_SECRET_ACCESS_KEY'));

        // Update .env file with new AWS settings
        $env_update = DotenvEditor::setKeys([
            'AWS_ACCESS_KEY_ID' => $encryptedAccessKey,
            'AWS_SECRET_ACCESS_KEY' => $encryptedSecretKey,
            'AWS_DEFAULT_REGION' => $request->input('AWS_DEFAULT_REGION'),
            'AWS_BUCKET' => $request->input('AWS_BUCKET'),
            'AWS_URL' => $request->input('AWS_URL'),
        ]);
        $env_update->save();

        $setting = ApiSetting::firstOrNew();
        $setting->aws_status = $request->input('aws_status') ? 1 : 0;
        $setting->save();

        return redirect('admin/api-setting')->with('success','Data has been updated.');
    }

    // Update YouTube API settings
    public function youtube(Request $request)
    {
        if(config('app.demolock') == 1){
            return back()->with('error','Disabled in demo'); // Return error if demo mode is enabled
        }

        $request->validate([
            'YOUTUBE_API_KEY' => 'required',
        ]);

        $encryptedApiKey = encrypt($request->input('YOUTUBE_API_KEY'));

        // Update .env file with new YouTube API key
        $env_update = DotenvEditor::setKeys([
            'YOUTUBE_API_KEY' => $encryptedApiKey,
        ]);
        $env_update->save();

        $setting = ApiSetting::firstOrNew();
        $setting->youtube_status = $request->input('youtube_status') ? 1 : 0;
        $setting->save();

        return redirect('admin/api-setting')->with('success','Data has been updated.');
    }

    // Update Vimeo API settings
    public function vimeo(Request $request)
    {
        if(config('app.demolock') == 1){
            return back()->with('error','Disabled in demo'); // Return error if demo mode is enabled
        }

        $request->validate([
            'VIMEO_CLIENT' => 'required',
            'VIMEO_SECRET' => 'required',
            'VIMEO_ACCESS' => 'required',
        ]);

        $encryptedClient = encrypt($request->input('VIMEO_CLIENT'));
        $encryptedSecret = encrypt($request->input('VIMEO_SECRET'));
        $encryptedAccess = encrypt($request->input('VIMEO_ACCESS'));

        // Update .env file with new Vimeo API settings
        $env_update = DotenvEditor::setKeys([
            'VIMEO_CLIENT' => $encryptedClient,
            'VIMEO_SECRET' => $encryptedSecret,
            'VIMEO_ACCESS' => $encryptedAccess,
        ]);
        $env_update->save();

        $setting = ApiSetting::firstOrNew();
        $setting->vimeo_status = $request->input('vimeo_status') ? 1 : 0;
        $setting->save();
        return redirect('admin/api-setting')->with('success','Vimeo API key has been updated.');
    }

    // Update Google Tag Manager settings
    public function gtm(Request $request)
    {
        if(config('app.demolock') == 1){
            return back()->with('error','Disabled in demo'); // Return error if demo mode is enabled
        }

        $request->validate([
            'GOOGLE_TAG_MANAGER_ID' => 'required',
        ]);

        $encryptedGtmId = encrypt($request->input('GOOGLE_TAG_MANAGER_ID'));

        // Update .env file with new Google Tag Manager ID
        $env_update = DotenvEditor::setKeys([
            'GOOGLE_TAG_MANAGER_ID' => $encryptedGtmId,
        ]);
        $env_update->save();

        $setting = ApiSetting::firstOrNew();
        $setting->gtm_status = $request->input('gtm_status') ? 1 : 0;
        $setting->save();

        return redirect('admin/api-setting')->with('success','Google Tag Manager ID has been updated.');
    }

    // Update OpenAI API key settings
    public function openapikey(Request $request)
    {
        if(config('app.demolock') == 1){
            return back()->with('error','Disabled in demo'); // Return error if demo mode is enabled
        }

        $request->validate([
            'openapikey' => 'required',
        ]);

        $openapikey = ApiSetting::firstOrNew();
        $openapikey->openapikey = encrypt($request->input('openapikey')); // Encrypt and store OpenAI API key
        $openapikey->gpt_toggle = $request->input('gpt_toggle') ? 1 : 0;
        $openapikey->save();
        return redirect('admin/api-setting')->with('success','Data has been added.');
    }
}
