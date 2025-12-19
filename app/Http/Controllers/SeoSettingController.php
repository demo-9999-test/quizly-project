<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SeoSetting;

class SeoSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:seo.manage', ['only' => ['index','update']]);
    }

    // -------------------- Show the SEO Settings form --------------------
    public function index()
    {
        $seosettings = SeoSetting::first();
        return view('admin.project-settings.seo-setting', compact('seosettings'));
    }

    // -------------------- Handle Update or Create --------------------
    public function update(Request $request)
    {
        $request->validate([
            'meta_data_desc' => 'required|string',
            'meta_data_keyword' => 'required|string',
        ]);

        try {
            $seosettings = SeoSetting::first();

            if ($seosettings) {
                $seosettings->meta_data_desc = $request->meta_data_desc;
                $seosettings->meta_data_keyword = $request->meta_data_keyword;
                $seosettings->save();
            } else {
                SeoSetting::create([
                    'meta_data_desc' => $request->meta_data_desc,
                    'meta_data_keyword' => $request->meta_data_keyword,
                ]);
            }

            return back()->with('success', 'Settings have been updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred: ' . $e->getMessage())->withInput();
        }
    }
}
