<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zone;
use Illuminate\Support\Facades\Validator;

class ZoneController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:zone.view', ['only' => ['index','show']]);
        $this->middleware('permission:zone.create', ['only' => ['create','importSave','store']]);
        $this->middleware('permission:zone.edit', ['only' => ['edit', ' update','updateStatus','updateOrder']]);
        $this->middleware('permission:zone.delete', ['only' => ['delete','bulk_delete','trash_bulk_delete','trash','restore','trashDelete']]);
    }
    //---------------------------------- Page View Code Start-------------------------------
    public function index()
    {
        $zone = Zone::all();
        return view('admin.zone.index',compact('zone'));
    }
    //---------------------------------- Page View Code End-------------------------------

    //---------------------------------- Create Page Code Start-------------------------------
     public function create()
     {
         return view('admin.zone.create');
     }
    //---------------------------------- Create Page Code Start-------------------------------

    //---------------------------------- Data Store Code start-------------------------------
    public function store(Request $request)
    {
        try{
            $request->validate([
                'image' =>'required|image|mimes:jpeg,jpg,png,svg',
                'name' => 'required|string|max:255',
                'desc' =>'required|string',
                'status' => 'nullable|boolean',
            ]);

            $zone = new Zone();
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('images/zone', $filename);
                $zone->image = $filename;
            }

            $zone->name = $request->name;
            $zone->description = strip_tags($request->desc);
            $zone->status = $request->has('status') ? 1 : 0;
            $zone->save();

            return redirect()->route('zone.index')->with('success','Zone data added successfully');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while adding zone: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Data Store Code end-------------------------------

    //---------------------------------- Edit Page Code start-------------------------------
    public function edit($id)
    {
        $zone = Zone::find($id);
        if (!$zone) {
            abort(404);
        }
        return view('admin.zone.edit', compact('zone'));
    }
    //---------------------------------- Edit Page Code end-------------------------------

    //---------------------------------- Update Code start-------------------------------
    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'image' => 'image|mimes:jpeg,jpg,png,svg',
                'name' => 'required|string|max:255',
                'desc' => 'required|string',
                'status' => 'nullable|boolean',
            ]);

            $zone = Zone::findOrFail($id);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('images/zone', $filename);
                if ($zone->image != null) {
                    $existingImagePath = public_path('images/zone/' . $zone->image);
                    if (file_exists($existingImagePath)) {
                        unlink($existingImagePath);
                    }
                }
                $zone->image = $filename;
            }

            $zone->name = $request->input('name');
            $zone->description = strip_tags($request->input('desc'));
            $zone->status = $request->has('status') ? 1 : 0;
            $zone->save();

            return redirect()->route('zone.index')->with('success','Zone data updated successfully');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while updating zone: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Update Code end-------------------------------

    //---------------------------------- Data Delete Code start-------------------------------
    public function destroy(string $id)
    {
        $zone = Zone::find($id);
        $zone->delete();
        return redirect('admin/zone');
    }
    //---------------------------------- Data Delete Code end-------------------------------

    //---------------------------------- Data Selected Delete Code start-------------------------------
    public function bulk_delete(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
            if ($validator->fails()) {
                return back()->with('warning', 'Atleast one item is required to be checked');
            }
            else{
                Zone::whereIn('id',$request->checked)->delete();
                return redirect('admin/zone')->with('delete','Data Delete Successfully');
            }
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while deleting zone: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Data Selected Delete Code end-------------------------------

    //---------------------------------- trash Code start-------------------------------
    public function trash()
    {
        $zone = Zone::onlyTrashed()->get();
        return view('admin.zone.trash', compact('zone'));
    }
    //---------------------------------- trash Code end-------------------------------

    //---------------------------------- trash restore Code start-------------------------------
    public function restore(string $id)
    {
        try{
            $zone = Zone::withTrashed()->find($id);
            if(!is_null($zone)){
                $zone->restore();
            }
            return redirect('admin/zone/trash')->with('success','Trash Data restore Successfully');
        }catch (\Exception $e) {
            $errorMessage = 'An error occurred while restoring zone: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- trash restore Code end-------------------------------

    //---------------------------------- Trash data Delete Code start-------------------------------
    public function trashDelete(string $id)
    {
        try{
            $zone = Zone::withTrashed()->find($id);

            if (!is_null($zone) && !empty($zone->image)) {
                $imagePath = public_path('images/zone/' . $zone->image);

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            if (!is_null($zone)) {
                $zone->forceDelete();
                return redirect('admin/zone/trash')->with('delete', 'Data Deleted Successfully');
            }

            return redirect('admin/zone/trash')->with('delete', 'Trash Data Deleted Successfully');
        }catch (\Exception $e) {
            $errorMessage = 'An error occurred while deleting zone: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Trash data Delete Code end-------------------------------

    //---------------------------------- Data Selected Delete Code start-------------------------------
    public function trash_bulk_delete(Request $request){
        // return $request;
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('warning', 'Atleast one item is required to be checked');
        }
        else{
            Zone::whereIn('id',$request->checked)->forceDelete();
            return redirect('admin/zone/trash')->with('delete','Data Delete Successfully');
        }
    }
    //---------------------------------- Data Selected Delete Code end-------------------------------
}
