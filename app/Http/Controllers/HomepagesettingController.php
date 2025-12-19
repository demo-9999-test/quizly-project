<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Homepagesetting;

class HomepagesettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:home.view', ['only' => ['index','show']]);
    }

    //------------------------------- index code start ------------------------
    public function index()
    {
        // Fetch the first record or create a new one if it doesn't exist
        $record = Homepagesetting::firstOrCreate([], [
            'slider' => 0,
            'counter' => 0,
            'categories' => 0,
            'friends' => 0,
            'discover_quiz' => 0,
            'battle' => 0,
            'zone' => 0,
            'testimonial' => 0,
            'blogs' => 0,
            'newsletter' => 0,
        ]);

        return view('admin.homepage-setting.index', compact('record'));
    }
    //------------------------------- index code end ------------------------

    //------------------------------- toggle setting code start ------------------------
    public function toggleSetting(Request $request)
    {
        $record = Homepagesetting::firstOrCreate();
        $setting = $request->input('setting');

        $validSettings = [
            'slider', 'counter', 'categories', 'friends', 'discover_quiz',
            'battle', 'zone', 'testimonial', 'blogs', 'newsletter'
        ];

        if (in_array($setting, $validSettings)) {
            $record->$setting = !$record->$setting;
            $record->save();
            return redirect()->route('admin.home.setting')->with('success', ucfirst(str_replace('_', ' ', $setting)) . ' setting updated successfully.');
        }

        return redirect()->route('admin.home.setting')->with('error', 'Invalid setting.');
    }
    //------------------------------- toggle setting code end ------------------------
}
