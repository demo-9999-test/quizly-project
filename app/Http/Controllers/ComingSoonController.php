<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comingsoon; // Corrected namespace

class ComingSoonController extends Controller
{
    //------------------------------- Index code start -------------------------------
    public function index() {
        $coming = Comingsoon::firstOrNew();
        return view('admin.coming_soon.index', compact('coming'));
    }
    //------------------------------- Index code end -------------------------------

    //------------------------------ Update code start ------------------------------
    public function update(Request $request)
    {
        try {
            $comingSoon = Comingsoon::firstOrNew();

            // Validate the incoming request data
            $validated = $request->validate([
                'heading' => 'required|string|max:255',
                'btn_txt' => 'required|string|max:255',
                'counter_one' => 'required|integer',
                'counter_two' => 'required|integer',
                'counter_three' => 'required|integer',
                'counter_four' => 'required|integer',
                'counter_one_txt' => 'required|string|max:255',
                'counter_two_txt' => 'required|string|max:255',
                'counter_three_txt' => 'required|string|max:255',
                'counter_four_txt' => 'required|string|max:255',
                'maintenance_mode' => 'boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'ip_address' => 'nullable|ip',
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_coming_soon.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/coming_soon/'), $filename);

                // Delete the old image if it exists
                if ($comingSoon->image) {
                    $existingImagePath = public_path('images/coming_soon/' . $comingSoon->image);
                    if (file_exists($existingImagePath)) {
                        unlink($existingImagePath);
                    }
                }

                $validated['image'] = $filename;
            }

            // Update all fields, including boolean fields
            $comingSoon->fill($validated);

            // Save the settings
            $comingSoon->save();

            return redirect()->back()->with('success', 'Coming Soon page settings updated successfully.');
        } catch (\Exception $e) {
            $errorMessage = 'An error occurred while updating the Coming Soon page settings: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //------------------------------ Update code end ------------------------------
}
