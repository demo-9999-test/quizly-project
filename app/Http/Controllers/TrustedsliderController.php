<?php

namespace App\Http\Controllers;

use App\Models\Trustedslider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrustedsliderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:trustedslider.view', ['only' => ['index','show']]);
        $this->middleware('permission:trustedslider.create', ['only' => ['create','store','importSave']]);
        $this->middleware('permission:trustedslider.edit', ['only' => ['edit', ' update','updateStatus','updateOrder']]);
        $this->middleware('permission:trustedslider.delete', ['only' => ['destroy','bulk_delete','trash_bulk_delete','trash','restore','trashDelete']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trustedsliders = Trustedslider::orderBy('position', 'asc')->get();
        return view('admin.trusted-slider.index', compact('trustedsliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.trusted-slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'url' => 'required|url',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $trustedslider = new Trustedslider;

            $trustedslider->url = $request->url;
            $trustedslider->status = $request->status ? 1 : 0;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalName();
                $filename = $extension;
                $file->move(public_path('images/trusted-slider/'), $filename);
                $trustedslider->image = $filename;
            }
            $trustedslider->save();

            return redirect()->route('trusted.slider.index')->with('success', 'Trusted slider created successfully.');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while adding the data: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $trustedslider = Trustedslider::findOrFail($id);
        return view('admin.trusted-slider.edit', compact('trustedslider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try{
            $trustedslider = Trustedslider::findOrFail($id);

            $request->validate([
                'url' => 'nullable|url',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $trustedslider->url = $request->url;
            $trustedslider->status = $request->status ? 1 : 0;


            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalName();
                $filename = $extension;
                $file->move(public_path('images/trusted-slider/'), $filename);
                $trustedslider->image = $filename;
            }

            $trustedslider->save();

            return redirect()->route('trusted.slider.index')->with('success', 'Trusted slider updated successfully.');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while updating the Trusted slider data: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $trustedslider = Trustedslider::findOrFail($id);

        // Define the image path
        $imagePath = public_path('images/trusted-slider/') . $trustedslider->image;

        // Delete image from the specified directory
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Delete the record
        $trustedslider->delete();

        return redirect()->route('trusted.slider.index')->with('success', 'Trusted slider deleted successfully.');
    }

    public function updateOrder(Request $request)
    {
        $id = $request->input('id');
        $position = $request->input('position');

        $slider = Trustedslider::find($id);
        $slider->position = $position;
        $slider->save();

        return response()->json(['success' => true]);
    }
}
