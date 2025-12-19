<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PackageFeatures;

class PackagesFeaturesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:packages_features.view', ['only' => ['index','show']]);
        $this->middleware('permission:packages_features.create', ['only' => ['store']]);
        $this->middleware('permission:packages_features.edit', ['only' => ['edit', ' update']]);
        $this->middleware('permission:packages_features.delete', ['only' => ['destroy','bulk_delete']]);
    }

    //---------------------------------- Page View Code start-------------------------------
    public function index()
    {
        return view('admin.package-features.index');
    }
 //---------------------------------- Page View Code end-------------------------------

//---------------------------------- Data Store Code start-------------------------------
public function store(Request $request)
{
    try{
    $request->validate([
        'title' => 'required',
    ]);
    $pfeatures = new PackageFeatures;
    $pfeatures->title = $request->input('title');
    $pfeatures->save();
    return back()->with('success','Features added successfully');
    }
    catch (\Exception $e) {
        $errorMessage = 'An error occurred while adding package features: ' . $e->getMessage();
        return back()->with('error', $errorMessage)->withInput();
    }
}
//---------------------------------- Data Store Code end-------------------------------

//---------------------------------- All Data Show Code start-------------------------------
public function show(Request $request)
{
    $pfeatures = PackageFeatures::orderBy('created_at','desc')->paginate(10);
    return view('admin.package-features.index', compact('pfeatures'));
}
//---------------------------------- All Data Show Code end-------------------------------

//---------------------------------- Edit Page Code start-------------------------------
public function edit(string $id)
{
    $pfeatures = PackageFeatures::find($id);
    if (!$pfeatures) {
        return redirect('admin/pfeatures');
    }
    return view('admin.package-features.edit', compact('pfeatures'));
}
//---------------------------------- Edit Page Code end-------------------------------

//---------------------------------- Update Code start-------------------------------
public function update(Request $request, string $id)
{
    try{
        $pfeatures = PackageFeatures::find($id);
        if (!$pfeatures) {
            return redirect('admin/packages-features');
        }
        $pfeatures->title = $request->input('title');
        $pfeatures->save();
        return redirect('admin/packages-features')->with('success','Features updated successfully');
    }
    catch (\Exception $e) {
        $errorMessage = 'An error occurred while updating package features: ' . $e->getMessage();
        return back()->with('error', $errorMessage)->withInput();
    }
}
//---------------------------------- Update Code End-------------------------------

//---------------------------------- Data Delete Code start-------------------------------
public function destroy(string $id)
{
    try{
        $pfeatures = PackageFeatures::find($id);
        $pfeatures->delete();
        return redirect('admin/packages-features')->with('delete','data delete successfully');
    }
    catch (\Exception $e) {
        $errorMessage = 'An error occurred while deleting package features: ' . $e->getMessage();
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
            return back()->with('warning','Atleast one iteam must be selected');
        }
        else{
            PackageFeatures::whereIn('id',$request->checked)->delete();
            return redirect('admin/packages-features')->with('delete','data delete successfully');
        }
    }
    catch (\Exception $e) {
        $errorMessage = 'An error occurred while deleting package features: ' . $e->getMessage();
        return back()->with('error', $errorMessage)->withInput();
    }
}
//---------------------------------- Data Selected Delete Code end-------------------------------
}

