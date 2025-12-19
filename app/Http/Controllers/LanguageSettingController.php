<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LanguageSetting;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;


class LanguageSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:language.view', ['only' => ['index','show']]);
        $this->middleware('permission:language.create', ['only' => ['store']]);
        $this->middleware('permission:language.edit', ['only' => ['edit', ' update','updateStatus']]);
        $this->middleware('permission:language.delete', ['only' => ['destroy','bulk_delete']]);
    }
    //---------------------------------- Page View Code start-------------------------------
    public function index()
    {
        return view('admin.language.index');
    }
//---------------------------------- Page View Code end-------------------------------

//---------------------------------- Data Store Code start-------------------------------

public function store(Request $request)
{
    try{
        if (config('app.demolock') == 1) {
            return back()->with('error','Demo mode is enabled. Data cannot be updated.');
        }
        // Validate the request data, including the image
        $request->validate([
            'local' => 'required|unique:language_settings,local',
            'name' => 'required',
        ]);

        // Create a new language record with specific fields
        $languageData = [
            'local' => $request->input('local'),
            'name' => $request->input('name'),
            'status'=> $request->input('status') ? 1 : 0,
        ];

        // Check if an image is uploaded
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageFileName = time() . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move('images/language', $imageFileName);
            $languageData['image'] = $imageFileName;
        }
        $language = LanguageSetting::create($languageData);
        if ($request->input('status')) {
            LanguageSetting::where('id', '!=', $language->id)->update(['status' => 0]);
        } else {
            $defaultLanguageCount = LanguageSetting::where('status', 1)->count();
            if ($defaultLanguageCount < 1) {
                return back()->with('warning','At least one language needs to be set as default!');
            }
        }
        Flash::success()->important();
        return redirect('admin/language')->with('success','Language has been added successfully');
    }catch (\Exception $e) {
        $errorMessage = 'An error occurred while adding Language: ' . $e->getMessage();
        return back()->with('error', $errorMessage)->withInput();
    }
}
//---------------------------------- Data Store Code end-------------------------------

//---------------------------------- All Data Show Code start-------------------------------
public function show(Request $request)
{
    $language = LanguageSetting::orderBy('created_at','desc')->paginate(7);
    return view('admin.language.index', compact('language'));
}
//---------------------------------- All Data Show Code end-------------------------------

//---------------------------------- Edit Page Code start-------------------------------

    public function edit(string $id)
    {
        $language = LanguageSetting::find($id);
        if (!$language) {
            return redirect('admin/language');
        }
        return view('admin.language.edit', compact('language'));
    }
//---------------------------------- Edit Page Code end-------------------------------

//---------------------------------- Update Code start-------------------------------

public function update(Request $request, string $id)
{
    try{
        if(config('app.demolock') == 1){
            return back()->with('error','Disabled in demo');
        }
        $language = LanguageSetting::find($id);
        if (!$language) {
            Flash::error('Language not found')->important();

            return redirect('admin/language');
        }
        $languageData = [
            'local' => $request->input('local'),
            'name' => $request->input('name'),
            'status' => $request->input('status') ? 1 : 0,
        ];
        $language->fill($languageData);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('images/language', $filename);
            if ($language->image != null) {
                $existingImagePath = public_path('images/language/' . $language->image);
                if (file_exists($existingImagePath)) {
                    unlink($existingImagePath);
                }
            }

            $language->image = $filename;
        }
        $language->save();
        if ($request->input('status')) {
            LanguageSetting::where('id', '!=', $language->id)->update(['status' => 0]);
        } else {
            $defaultLanguageCount = LanguageSetting::where('status', 1)->count();
            if ($defaultLanguageCount < 1) {
                return back()->with('warning','At least one language needs to be set as default!');
            }
        }
        Flash::success()->important();

        return redirect('admin/language')->with('success','Language has been updated.');
    }
    catch (\Exception $e) {
        $errorMessage = 'An error occurred while updating Language: ' . $e->getMessage();
        return back()->with('error', $errorMessage)->withInput();
    }
}

//---------------------------------- Update Code End-------------------------------


//---------------------------------- Data Delete Code start-------------------------------
    public function destroy(string $id)
    {
        try{
        $language = LanguageSetting::find($id);
        if($language->status ==1){
            return back()->with('error','Cannot Delete Default Language');
       }
        if ($language->image != null) {
            $content = @file_get_contents(public_path() . '/images/language/' . $language->image);
            if ($content) {
                unlink(public_path() . "/images/language/" . $language->image);
            }
        }
        $language->delete();
        Flash::success()->important();

        return redirect('admin/language')-with('success','Data Delete Successfully');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while deleting Language: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
//---------------------------------- Data Delete Code End-------------------------------

//---------------------------------- Data Selected Delete Code start-------------------------------

public function bulk_delete(Request $request)
{
    try{
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('warning','Atleast one item is required to be checked');
        }
        else{
            LanguageSetting::whereIn('id',$request->checked)->delete();
            return redirect('admin/language')->with('success','Data Delete Successfully');
        }
    }
    catch (\Exception $e) {
        $errorMessage = 'An error occurred while deleting Language: ' . $e->getMessage();
        return back()->with('error', $errorMessage)->withInput();
    }
}

//---------------------------------- Data Selected Delete Code end-------------------------------

//---------------------------------- Status  Code start-------------------------------
public function updateStatus(Request $request)
{
    if(config('app.demolock') == 1){
        return back()->with('error','Disabled in demo');
    }

    $language = LanguageSetting::findOrFail($request->id);

    // Check if the status is being changed to active (1)
    if ($request->status == 1) {
        // Update the language status
        $language->status = $request->status;
        $language->save();

        // Update session language
        Session::put('changed_language', $language->local);

        // Set all other languages' statuses to 0
        LanguageSetting::where('id', '!=', $request->id)->update(['status' => 0]);

        return response()->json(['message' => 'Language switched successfully'], 200);

    } else {
        // If the status is not being changed to active, just update the status
        $language->status = $request->status;
        $language->save();
        return response()->json(['message' => 'Status changed successfully'], 200);

    }
}

public function switchLanguage($local, $image = null)
{
    if(config('app.demolock') == 1){
        return back()->with('error','Disabled in demo');
    }

    $language = DB::table('language_settings')->where('local', $local)->first();
    if ($language) {
        DB::table('language_settings')->update(['status' => 0]);
        DB::table('language_settings')->where('id', $language->id)->update(['status' => 1]);
        Session::put('changed_language', $local);

        if ($image) {
            $imagePath = "/images/language/" . $image;
            Session::put('changed_image', $imagePath);
        }
    }
    return back();
}
//---------------------------------- languageSwitch Code end-------------------------------

}
