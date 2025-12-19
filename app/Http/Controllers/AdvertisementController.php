<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Flash;

class AdvertisementController extends Controller
{
    public function show()
    {
        $advertisement = Advertisement::all();
        return view('admin.advertisement.index', compact('advertisement'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'position' => 'required|string',
            'page_type' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $filename = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/advertisement'), $filename);
        }

        Advertisement::create([
            'url' => $request->url,
            'position' => $request->position,
            'page_type' => $request->page_type,
            'image' => $filename,
        ]);

        return redirect()->route('advertisement.show')->with('success', 'Advertisement added successfully.');
    }

    public function edit(string $id)
    {
        $advertisement = Advertisement::find($id);
        if (!$advertisement) {
            Flash::error('advertisement not found')->important();
            return redirect()->route('advertisement.show');
        }
        return view('admin.advertisement.edit', compact('advertisement'));
    }

    public function update(Request $request, string $id)
{
    try {
        $advertisement = Advertisement::find($id);
        if (!$advertisement) {
            Flash::error('advertisement not found.')->important();
            return redirect()->route('advertisement.show');
        }

        $request->validate([
            'url' => 'required|url',
            'position' => 'required',
            'page_type' => 'required',
            'image' => 'nullable|image|max:2048', // Revert to image validation since file is detected
        ]);

        $advertisement->url = $request->input('url');
        $advertisement->position = $request->input('position');
        $advertisement->page_type = $request->input('page_type');
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $destinationPath = public_path('images/advertisement');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                $file->move($destinationPath, $filename);
                if ($advertisement->image && file_exists(public_path('images/advertisement/' . $advertisement->image))) {
                    unlink(public_path('images/advertisement/' . $advertisement->image));
                }
                $advertisement->image = $filename;
            } else {
                return back()->with('error', 'Invalid image file uploaded.')->withInput();
            }
        }

        // Debug before save
        // dd($advertisement->toArray(), $advertisement->save());

        if ($advertisement->save()) {
            return redirect()->route('advertisement.show')->with('success', 'advertisement has been updated.');
        } else {
            return back()->with('error', 'Failed to update advertisement. Please check database constraints.')->withInput();
        }
    } catch (\Exception $e) {
        $errorMessage = 'An error occurred while updating advertisement: ' . $e->getMessage();
        return back()->with('error', $errorMessage)->withInput();
    }
}
    public function destroy($id)
    {
        $advertisement = Advertisement::findOrFail($id);
        if ($advertisement->image) {
            $path = public_path('images/advertisement/' . $advertisement->image);
            if (file_exists($path)) {
                unlink($path);
            }
        }
        $advertisement->delete();
        return redirect()->route('advertisement.show')->with('success', 'Advertisement deleted successfully.');
    }

    public function bulk_delete(Request $request)
{
    $ids = $request->input('checked');

    if (!$ids || !is_array($ids)) {
        return redirect()->route('advertisement.show')->with('error', 'No advertisements selected.');
    }

    foreach ($ids as $id) {
        $advertisement = Advertisement::find($id);
        if ($advertisement) {
            if ($advertisement->image) {
                $path = public_path('images/advertisement/' . $advertisement->image);
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $advertisement->delete();
        }
    }

    return redirect()->route('advertisement.show')->with('success', 'Selected advertisements deleted.');
}


}