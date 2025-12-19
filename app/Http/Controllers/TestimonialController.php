<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Models\Testimonial;
use Laracasts\Flash\Flash;

class TestimonialController extends Controller{
    public function __construct()
    {
        $this->middleware('permission:testimonial.view', ['only' => ['index','show']]);
        $this->middleware('permission:testimonial.create', ['only' => ['store']]);
        $this->middleware('permission:testimonial.edit', ['only' => ['edit', ' update','updateStatus','updateOrder']]);
        $this->middleware('permission:testimonial.delete', ['only' => ['destroy','bulk_delete','trash_bulk_delete','trash','restore','trashDelete']]);
    }

    //---------------------------------- Page View Code start-------------------------------
    public function index() {
        return view('admin.testimonial.index');
    }
    //---------------------------------- Page View Code end-------------------------------

    //---------------------------------- Data Store Code start-------------------------------

    public function store(Request $request)
    {
        try{
            $messages = [
                'client_name.required' => 'Client Name is required.',
                'rating.required' => 'Rating is required.',
                'details.required' => 'Details are required.',
                'images.required' => 'Image is required.',
                'images.image' => 'The file must be an image.',
                'images.mimes' => 'The image must be a file of type: jpeg, png.',
            ];

            // Validate the request data with custom error messages
            $validator = Validator::make($request->all(), [
                'client_name' => 'required',
                'rating' => 'required',
                'details' => 'required',
                'images' => 'required|image|mimes:jpeg,png',
            ], $messages);

            // Check if the validation fails
            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $message) {
                    Flash::warning($message)->important();
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Create a new Testimonial record with specific fields
            $testimonial = new Testimonial;
            $testimonial->client_name = $request->input('client_name');
            $testimonial->rating = $request->input('rating');
            $testimonial->details = $request->input('details');
            $action = $request->input('status');
            if ($action === 'draft') {
                $testimonial->status = 0; // Draft status
            } elseif ($action === 'publish') {
                $testimonial->status = 1; // Publish status
            }

            // Handle the file upload
            if ($request->hasFile('images')) {
                $file = $request->file('images');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('images/testimonial', $filename);
                $testimonial->images = $filename;
            }

            $testimonial->save();
            return redirect('admin/testimonial')->with('success','Testimonial data has been added.');
        }catch (\Exception $e) {
            $errorMessage = 'An error occurred while adding the Testimonial: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }

    //---------------------------------- Data Store Code end-------------------------------

    //---------------------------------- All Data Show Code start-------------------------------
    public function show(Request $request) {
        $testimonials = Testimonial::orderBy('position')->paginate(7);
        return view('admin.testimonial.index', compact('testimonials'));
    }
    //---------------------------------- All Data Show Code end-------------------------------

    //---------------------------------- Edit Page Code start-------------------------------
    public function edit(string $id){
        $testimonial = Testimonial::find($id);
        if (!$testimonial) {
            Flash::error('Testimonial not found')->important();
            return redirect('admin/Testimonial');
        }

        return view('admin.testimonial.edit', compact('testimonial'));
    }
    //---------------------------------- Edit Page Code end-------------------------------

    //---------------------------------- Update Code start-------------------------------
    public function update(Request $request, string $id){
        try{
            $testimonial = Testimonial::find($id);
            if (!$testimonial) {
                return redirect('admin/testimonial')->with('error','Testimonial not found.');
            }
            $testimonial->client_name = $request->input('client_name');
            $testimonial->rating = $request->input('rating');
            $testimonial->details = $request->input('details');
            $action = $request->input('status');
            if ($action === 'draft') {
            $testimonial->status = 0; // Draft status
            } elseif ($action === 'publish') {
                $testimonial->status = 1; // Publish status
            }
            if ($request->hasFile('images')) {
                $file = $request->file('images');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('images/testimonial', $filename);

                // Remove existing testimonial images if they exist
                if ($testimonial->images != null) {
                    $existingImagePath = public_path('images/testimonial/' . $testimonial->images);
                    if (file_exists($existingImagePath)) {
                        unlink($existingImagePath);
                    }
                }

                $testimonial->images = $filename;
            }
            $testimonial->save();
            return redirect('admin/testimonial','Testimonial has been updated.');
        }catch (\Exception $e) {
            $errorMessage = 'An error occurred while adding the Testimonial: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Update Code End-------------------------------

    //---------------------------------- Status  Code start-------------------------------

    public function updateStatus(Request $request)
    {
        // return $request;
        $testimonial = Testimonial::find($request->id);
        $testimonial->status = $request->status;
        $testimonial->save();
        Flash::success('Status change successfully.');
        return redirect('admin/testimonial');
    }
    //---------------------------------- Status  Code end-------------------------------

    //---------------------------------- Data Delete Code start-------------------------------

    public function destroy(string $id){
        $testimonial = Testimonial::find($id);
        $testimonial->delete();
        return redirect('admin/testimonial')->with('delete','Data Delete Successfully');
    }
    //---------------------------------- Data Delete Code End-------------------------------

    //---------------------------------- Data Selected Delete Code start-------------------------------
    public function bulk_delete(Request $request){
        // return $request;
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('warning','Atleast one item is required to be checked');
        }
        else{
            Testimonial::whereIn('id',$request->checked)->delete();
            return redirect('admin/testimonial')->with('delete','Data Delete Successfully');
        }
    }
    //---------------------------------- Data Selected Delete Code end-------------------------------

    //---------------------------------- Data Selected Delete Code start-------------------------------
    public function trash_bulk_delete(Request $request){
        // return $request;
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('warning','Atleast one item is required to be checked');
        }
        else{
            Testimonial::whereIn('id',$request->checked)->forceDelete();
            return redirect('admin/testimonial')->with('delete','Data Delete Successfully');
        }
    }
    //---------------------------------- Data Selected Delete Code end-------------------------------

    //---------------------------------- trash Code start-------------------------------
    public function trash()
    {
        $testimonial = Testimonial::onlyTrashed()->get(); // Use onlyTrashed() instead of onlyTrasned()
        return view('admin.testimonial.trash', compact('testimonial'));
    }
    //---------------------------------- trash Code end-------------------------------

    //---------------------------------- Data restore Code start-------------------------------
    public function restore(string $id)
    {
        $testimonial = Testimonial::withTrashed()->find($id);
        if(!is_null($testimonial)){
            $testimonial->restore();
        }
        return redirect('admin/testimonial')->with('success','Trash Data restore Successfully');
    }
    //---------------------------------- Data restore Code End-------------------------------

    //---------------------------------- Trash data Delete Code start-------------------------------
    public function trashDelete(string $id)
    {
        $testimonial = Testimonial::withTrashed()->find($id);
        if (!is_null($testimonial)) {
            if ($testimonial->images != null) {
                $content = @file_get_contents(public_path() . '/images/testimonial/' . $testimonial->images);
                if ($content) {
                    unlink(public_path() . "/images/testimonial/" . $testimonial->images);
                }
            }
            $testimonial->forceDelete();

            return redirect('admin/post/trash')->with('delete','Data Delete Successfully');
        }

        return redirect('admin/testimonial')->with('delete','Trash Data Delete Successfully');
    }
    //----------------------------------Trash data Delete Code start-------------------------------

    //  -----------------------darg and drop order update code  start -----------------
    public function updateOrder(Request $request)
    {
        $id = $request->input('id');
        $position = $request->input('position');

        $testimonial = Testimonial::find($id);
        $testimonial->position = $position;
        $testimonial->save();

        return response()->json(['success' => true]);
    }
    //  -----------------------darg and drop order update code  end -----------------
}
