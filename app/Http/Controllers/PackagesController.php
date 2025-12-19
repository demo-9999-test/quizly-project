<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Packages;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use Torann\Currency\Facades\Currency;
use App\Models\PackageFeatures;

class PackagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:packages.view', ['only' => ['index','show']]);
        $this->middleware('permission:packages.create', ['only' => ['store']]);
        $this->middleware('permission:packages.edit', ['only' => ['edit', ' update','updateStatus']]);
        $this->middleware('permission:packages.delete', ['only' => ['destroy','bulk_delete']]);
    }

    //---------------------------------- Page View Code start-------------------------------
    public function index()
    {
        return view('admin.packages.index');
    }
//---------------------------------- Page View Code end-------------------------------

//---------------------------------- Data Store Code start-------------------------------

public function store(Request $request)
{
    try{
        $currency = DB::table('currencies')->where('default', 1)->first();
        // Validate the request data
        $request->validate([
            'plan_id' => 'required|unique:packages',
            'pname' => 'required',
            'preward' => 'required|numeric',
            'pfeatures_id' => 'required',

        ]);

        $package  = new Packages;
        $package->plan_id = $request->input('plan_id');
        $package->pname = $request->input('pname');
        $package->preward = $request->input('preward');
        $package->pfeatures_id = implode(',', $request->input('pfeatures_id'));
        $package->currency = $currency->code;
        $package->plan_amount = $request->input('plan_amount');

        $package->status = $request->input('status') ? 1 : 0;
        $package->save();

        return redirect('admin/packages')->with('success','Package has been added.');
    }
    catch (\Exception $e) {
        $errorMessage = 'An error occurred while adding package: ' . $e->getMessage();
        return back()->with('error', $errorMessage)->withInput();
    }
}
//---------------------------------- Data Store Code end-------------------------------

//---------------------------------- All Data Show Code start-------------------------------
public function show(Request $request)
{
   $pfeatures = PackageFeatures::get();
   $currency = DB::table('currencies')->where('default','1')->first();
   $package = Packages::orderBy('created_at','desc')->paginate(10);
   return view('admin.packages.index', compact('package','pfeatures','currency'));
}
//---------------------------------- All Data Show Code end-------------------------------

//---------------------------------- Edit Page Code start-------------------------------
    public function edit(string $id)
    {
        $pfeatures = PackageFeatures::get();
        $package = Packages::find($id);
        if (!$package) {
            Flash::error('blog not found')->important();
        return redirect('admin/features');
        }
        return view('admin.packages.edit', compact('package','pfeatures'));
    }
//---------------------------------- Edit Page Code end-------------------------------

//---------------------------------- Update Code start-------------------------------
public function update(Request $request, string $id)
{
    try{
        $currency = DB::table('currencies')->where('default', 1)->first();

        $package = Packages::find($id);
        if (!$package) {
            Flash::error('features not found')->important();

            return redirect('admin/packages-features');
        }
        $package->plan_id = $request->input('plan_id');
        $package->pname = $request->input('pname');
        $package->pfeatures_id = implode(',', $request->input('pfeatures_id'));
        $package->currency = $currency->code;
        $package->plan_amount = $request->input('plan_amount');
        $package->preward = $request->input('preward');

        $package->status = $request->input('status') ? 1 : 0;
        $package->save();

        return redirect('admin/packages')->with('success','features has been updated.');
    }
    catch (\Exception $e) {
        $errorMessage = 'An error occurred while updating package: ' . $e->getMessage();
        return back()->with('error', $errorMessage)->withInput();
    }
}
//---------------------------------- Update Code End-------------------------------

//---------------------------------- Status  Code start-------------------------------
public function updateStatus(Request $request)
{
    try{
        // return $request;
        $package = Packages::find($request->id);
        $package->status = $request->status;
        $package->save();
        return redirect('admin/packages')->with('success','Status change successfully.');
    }
    catch (\Exception $e) {
        $errorMessage = 'An error occurred while updating status: ' . $e->getMessage();
        return back()->with('error', $errorMessage)->withInput();
    }
}
//---------------------------------- Status  Code end-------------------------------

//---------------------------------- Data Delete Code start-------------------------------
   public function destroy(string $id)
   {
       $package = Packages::find($id);
       $package->delete();
       Flash::success('Data Delete Successfully')->important();
       return redirect('admin/packages');
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
           return back()->with('warning','Atleast one item must be selected');
       }
       else{
        Packages::whereIn('id',$request->checked)->delete();
           return redirect('admin/packages')->with('delete','Data Delete Successfully');
        }
    }
    catch (\Exception $e) {
        $errorMessage = 'An error occurred while deleting status: ' . $e->getMessage();
        return back()->with('error', $errorMessage)->withInput();
    }
}
//---------------------------------- Data Selected Delete Code end-------------------------------
}


