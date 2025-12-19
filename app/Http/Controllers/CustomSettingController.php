<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Laracasts\Flash\Flash;

class CustomSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:custom.manage', ['only' => ['index','updateCodeCss','updateCodeJs']]);
    }
    //---------------------------------- Page View Code start-------------------------------
    public function index()
    {
        return view('admin.project-settings.custom-setting');
    }
  //---------------------------------- Page View Code end-------------------------------

  public function updateCodeCss(Request $request)
  {
    try
    {
        if (config('app.demolock') == 0) {
            return back()->with('error','Demo mode is enabled. Data cannot be updated.');
        }
        $customCss = $request->input('custom_css');

        // Generate unique filenames
        $cssFileName = 'custom.css';

        // Save CSS and JS to files
        $cssFilePath = public_path('admin_theme/assets/css/' . $cssFileName);

        // Ensure the directory exists before writing to the file
        File::ensureDirectoryExists(public_path('admin_theme/assets/css'));

        // Save CSS and JS to files
        File::put($cssFilePath, $customCss);
        return redirect()->back()->with('success','Code updated successfully!');
    }
    catch (\Exception $e) {
        $errorMessage = 'An error occurred while updating the code: ' . $e->getMessage();
        return back()->with('error', $errorMessage)->withInput();
    }
  }

  public function updateCodeJs(Request $request)
  {
    try{
    if (config('app.demolock') == 0) {
        return back()->with('error','Demo mode is enabled. Data cannot be updated.');
    }
      $customJs = $request->input('custom_js');

      // Generate unique filenames
      $jsFileName = 'custom.js';

      // Save CSS and JS to files
      $jsFilePath = public_path('admin_theme/assets/js/' . $jsFileName);

      // Ensure the directory exists before writing to the file
      File::ensureDirectoryExists(public_path('admin_theme/assets/js'));

      // Save CSS and JS to files
      File::put($jsFilePath, $customJs);
      return redirect()->back()->with('success','Code updated successfully!');
    }catch (\Exception $e) {
        $errorMessage = 'An error occurred while updating the code: ' . $e->getMessage();
        return back()->with('error', $errorMessage)->withInput();
    }
  }
}
