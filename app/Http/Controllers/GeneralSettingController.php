<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;
use Laracasts\Flash\Flash;


class GeneralSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:general.manage', ['only' => ['index','store','show']]);
    }

    //---------------------------------- Page View Code start-------------------------------
    public function index()
    {
        return view('admin.project-settings.general-setting');
    }
//---------------------------------- Page View Code end-------------------------------

//---------------------------------- Data Store Code start-------------------------------

public function store(Request $request)
{
    try{
        $request->validate([
            'contact' => 'required',
            'email' => 'required|email',
            'support_email' => 'required|email',
            'address' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'favicon_logo' => 'nullable|image|mimes:jpeg,png,ico|max:2048',
            'preloader_logo' => 'nullable|image|mimes:jpeg,png,gif|max:2048',
        ]);

        if (env('DEMOLOCK') == 1) {
            Flash::error('Demo mode is enabled. Data cannot be updated.')->important();
            return back();
        }

        $settings = GeneralSetting::firstOrNew();

        $settings->contact = $request->input('contact');
        $settings->email = $request->input('email');
        $settings->support_email = $request->input('support_email');
        $settings->address = $request->input('address');
        $settings->iframe_url = $request->input('iframe_url');
        $settings->promo_text = $request->input('promo_text');
        $settings->promo_link = $request->input('promo_link');
        $settings->preloader_enable_status = $request->has('preloader_enable_status');
        $settings->env_protection = $request->has('env_protection');

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = time() . '_logo.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images/logo'), $logoName);
            $settings->logo = $logoName;
        }

        // Handle favicon upload
        if ($request->hasFile('favicon_logo')) {
            $favicon = $request->file('favicon_logo');
            $faviconName = time() . '_favicon.' . $favicon->getClientOriginalExtension();
            $favicon->move(public_path('images/favicon'), $faviconName);
            $settings->favicon_logo = $faviconName;
        }

        // Handle preloader logo upload
        if ($request->hasFile('preloader_logo')) {
            $preloader = $request->file('preloader_logo');
            $preloaderName = time() . '_preloader.' . $preloader->getClientOriginalExtension();
            $preloader->move(public_path('images/preloader'), $preloaderName);
            $settings->preloader_logo = $preloaderName;
        }
        if ($request->hasFile('breadcrumb_img')) {
            $breadcrumb_img = $request->file('breadcrumb_img');
            $breadcrumb_imgFilename = time() . '.' . $breadcrumb_img->getClientOriginalExtension();
            $breadcrumb_img->move('images/breadcrumb', $breadcrumb_imgFilename);
            if ($settings->breadcrumb_img != null) {
                $existingImagePath = public_path('images/breadcrumb/' . $settings->breadcrumb_img);
                if (file_exists($existingImagePath)) {
                    unlink($existingImagePath);
                }
            }
            $settings->breadcrumb_img = $breadcrumb_imgFilename;
        }

        $settings->save();

        $env_update = DotenvEditor::setKeys([
            'APP_URL' => $request->input('APP_URL'),
            'APP_NAME' => $request->input('APP_NAME'),
        ]);
        $env_update->save();

        return back()->with('success','Settings have been updated successfully.');
    }

    catch (\Exception $e) {
        $errorMessage = 'An error occurred while updating settings: ' . $e->getMessage();
        return back()->with('error', $errorMessage)->withInput();
    }
}

//---------------------------------- Data Store Code end-------------------------------

//---------------------------------- All Data Show Code start-------------------------------

public function show()
{
    $settings = GeneralSetting::first();
    // Retrieve values from the .env file using config
    $appUrl = config('app.url');
    $appName = config('app.name');

    return view('admin.project-settings.general-setting', compact('settings', 'appUrl', 'appName'));
}
//---------------------------------- All Data Show Code end-------------------------------

}
