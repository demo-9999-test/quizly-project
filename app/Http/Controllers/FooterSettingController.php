<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FooterSetting;
use Illuminate\Support\Facades\Storage;
use Laracasts\Flash\Flash;

class FooterSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:footersetting.manage', ['only' => ['index','store','show']]);
    }

    //---------------------------------- Page View Code start-------------------------------
    public function index()
    {
        return view('admin.project-settings.footer_setting');
    }
//---------------------------------- Page View Code end-------------------------------

//---------------------------------- Data Store Code start-------------------------------

public function store(Request $request)
{
    if (config('app.demolock') == 1) {
        return back()->with('error','Demo mode is enabled. Data cannot be updated.');
    }
    $settings = FooterSetting::firstOrNew();
    $settings->title = $request->input('title');
    $settings->fb_url = $request->input('fb_url');
    $settings->linkedin_url = $request->input('linkedin_url');
    $settings->twitter_url = $request->input('twitter_url');
    $settings->insta_url = $request->input('insta_url');
    $settings->desc = $request->input('desc');
    $settings->copyright_text = $request->input('copyright_text');
    if ($request->hasFile('image')) {
        $logoFile = $request->file('image');
        $logoFilename = time() . '.' . $logoFile->getClientOriginalExtension();
        $logoFile->move('images/footer', $logoFilename);
        if ($settings->image != null) {
            $existingImagePath = public_path('images/footer/' . $settings->image);
            if (file_exists($existingImagePath)) {
                unlink($existingImagePath);
            }
        }
        $settings->image = $logoFilename;
    }
     // Handle footer image upload
     if ($request->hasFile('footer_logo')) {
        $footerFile = $request->file('footer_logo');
        $footerFilename = time() . '.' . $footerFile->getClientOriginalExtension();
        $footerFile->move('images/footer_logo', $footerFilename);
        if ($settings->footer_logo != null) {
            $existingImagePath = public_path('images/footer_logo/' . $settings->footer_logo);
            if (file_exists($existingImagePath)) {
                unlink($existingImagePath);
            }
        }
        $settings->footer_logo = $footerFilename;
    }
    $settings->save();

    return back()->with('success','Data has been Updated successfully.');
}
//---------------------------------- Data Store Code end-------------------------------

//---------------------------------- All Data Show Code start-------------------------------

public function show()
{
    $settings = FooterSetting::first();
    return view('admin.project-settings.footer_setting', compact('settings'));
}
//---------------------------------- All Data Show Code end-------------------------------
}
