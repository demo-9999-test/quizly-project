<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Models\Slider;
use Laracasts\Flash\Flash;

class SliderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:slider.view', ['only' => ['index','show']]);
        $this->middleware('permission:slider.create', ['only' => ['store']]);
        $this->middleware('permission:slider.edit', ['only' => ['edit', ' update','updateStatus','updateOrder']]);
        $this->middleware('permission:slider.delete', ['only' => ['destroy','bulk_delete','trash_bulk_delete','trash','restore','trashDelete']]);
    }

    //---------------------------------- Page View Code start-------------------------------
    public function index()
    {
        return view('admin.slider.index');
    }
    //---------------------------------- Page View Code end-------------------------------

    //---------------------------------- Data Store Code start-------------------------------
    public function store(Request $request)
    {
        try{
            $request->validate([
                'heading' => 'required',
                'images' => 'required|image|mimes:jpeg,png',
                'details' => 'required',
                'text_position' => 'required',
                'btn_status' => 'nullable|boolean',
                'buttontext' => 'nullable',
            ]);

            // Create a new slider record with specific fields
            $slider = new Slider;
            $slider->heading = $request->input('heading');
            $slider->sub_heading = $request->input('sub_heading');
            $slider->details = $request->input('details');
            $slider->text_position = $request->input('text_position');
            $slider->btn_status = $request->has('btn_status') ? 1 : 0;
            $slider->buttontext = $request->input('buttontext');
            $action = $request->input('status');
                    if ($action === 'draft') {
                        $slider->status = 0; // Draft status
                    } elseif ($action === 'publish') {
                        $slider->status = 1; // Publish status
                    }
            // Handle the file upload
            if ($request->hasFile('images')) {
                $file = $request->file('images');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('images/slider', $filename);
                $slider->images = $filename;
            }
            $slider->save();
            return redirect('admin/slider')->with('success','Data has been added.');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while adding the data: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Data Store Code end-------------------------------

    //---------------------------------- All Data Show Code start-------------------------------
    public function show(Request $request)
    {
        $slider = Slider::orderBy('position')->paginate(7);
        return view('admin.slider.index', compact('slider'));
    }
    //---------------------------------- All Data Show Code end-------------------------------

    //---------------------------------- Edit Page Code start-------------------------------
    public function edit(string $id)
    {
        $slider = Slider::find($id);
        if (!$slider) {
            Flash::error('slider not found');
            return redirect('admin/slider');
        }
        return view('admin.slider.edit', compact('slider'));
    }
    //---------------------------------- Edit Page Code end-------------------------------

    //---------------------------------- Update Code start-------------------------------
    public function update(Request $request, string $id)
    {
        try{
            $slider = Slider::find($id);
            if (!$slider) {
                Flash::error('slider not found');
                return redirect('admin/slider');
            }
            $slider->heading = $request->input('heading');
            $slider->sub_heading = $request->input('sub_heading');
            $slider->details = $request->input('details');
            $slider->status = $request->input('status') ? 1 : 0;
            $slider->text_position = $request->input('text_position');
            $action = $request->input('status');
                if ($action === 'draft') {
                    $slider->status = 0; // Draft status
                } elseif ($action === 'publish') {
                    $slider->status = 1; // Publish status
                }
                if ($request->hasFile('images')) {
                    $file = $request->file('images');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('images/slider', $filename);
                    if ($slider->images != null) {
                        $existingImagePath = public_path('images/slider/' . $slider->images);
                        if (file_exists($existingImagePath)) {
                            unlink($existingImagePath);
                        }
                    }

                    $slider->images = $filename;
                }
            $slider->save();

            return redirect('admin/slider')->with('success','Data has been updated.');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while updating the data: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }

    //---------------------------------- Update Code End-------------------------------

    //---------------------------------- Data Delete Code start-------------------------------
    public function destroy(string $id)
    {
        try{
            $slider = Slider::find($id);
            $slider->delete();

            return redirect('admin/slider')->with('delete','Data Delete Successfully');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while deleting the data: ' . $e->getMessage();
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
            Slider::whereIn('id',$request->checked)->delete();
            return redirect('admin/slider')->with('delete','Data Delete Successfully');
        }
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while deleting the data: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }   
    //---------------------------------- Data Selected Delete Code end-------------------------------

    //---------------------------------- Data Selected Delete trash Code start-------------------------------
    public function trash_bulk_delete(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
            if ($validator->fails()) {
                return back()->with('warning','Atleast one item is required to be checked');
            }
            else{
                Slider::whereIn('id',$request->checked)->forceDelete();
                return redirect('admin/slider')->with('delete','Data Delete Successfully');
            }
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while deleting the data: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Data Selected Delete tarsh Code end-------------------------------

    //---------------------------------- trash Code start-------------------------------
    public function trash()
    {
        $slider = Slider::onlyTrashed()->get();

        return view('admin.slider.trash', compact('slider'));
    }
    //---------------------------------- trash Code end-------------------------------

    //---------------------------------- Data restore Code start-------------------------------
    public function restore(string $id)
    {
        try{$slider = Slider::withTrashed()->find($id);
        if(!is_null($slider)){
        $slider->restore();
        }
        return redirect('admin/slider/trash')->with('success','Data restore Successfully');
        }catch (\Exception $e) {
            $errorMessage = 'An error occurred while restoring the data: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Data restore Code End-------------------------------

    //---------------------------------- Trash data Delete Code start-------------------------------
    public function trashDelete(string $id)
    {
        $slider = Slider::withTrashed()->find($id);
        if (!is_null($slider)) {
            if ($slider->images != null) {
                $content = @file_get_contents(public_path() . '/images/slider/' . $slider->images);
                if ($content) {
                    unlink(public_path() . "/images/slider/" . $slider->images);
                }
            }
            $slider->forceDelete();

            return redirect('admin/post/trash')->with('delete','Data Delete Successfully');
        }
        return redirect('admin/slider/trash')->with('delete','Data Delete Successfully');
    }
    //----------------------------------Trash data Delete Code start-------------------------------

    //---------------------------------- Status  Code start-------------------------------
    public function updateStatus(Request $request)
    {
        // return $request;
        $slider = Slider::find($request->id);
        $slider->status = $request->status;
        $slider->save();

        return redirect('admin/slider/trash')->with('success','Status change successfully.');
    }
//---------------------------------- Status  Code end-------------------------------

//-----------------------darg and drop order update code  start -----------------
public function updateOrder(Request $request)
{
    $id = $request->input('id');
    $position = $request->input('position');

    $slider = Slider::find($id);
    $slider->position = $position;
    $slider->save();

    return response()->json(['success' => true]);
}
//-----------------------darg and drop order update code  end -----------------
}
