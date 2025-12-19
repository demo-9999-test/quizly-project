<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Notifications\BadgeEarned;
use DB;
use Laracasts\Flash\Flash;
use Auth;
use App\Models\GeneralSetting;
class BadgeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('permission:badge.view', ['only' => ['index','show']]);
        $this->middleware('permission:badge.create', ['only' => ['create','importSave','store']]);
        $this->middleware('permission:badge.edit', ['only' => ['edit', ' update','updateStatus','updateOrder']]);
        $this->middleware('permission:badge.delete', ['only' => ['delete','bulk_delete','trash_bulk_delete','trash','restore','trashDelete']]);
    }

    //---------------------------------- Page View Code Start-------------------------------
    public function index()
    {
        $badges = Badge::all();
        return view('admin.badge.index',compact('badges'));
    }
    //---------------------------------- Page View Code End-------------------------------

    //---------------------------------- Create Page Code Start-------------------------------
    public function create()
    {
        return view('admin.badge.create');
    }
    //---------------------------------- Create Page Code Start-------------------------------

    //---------------------------------- Data Store Code start-------------------------------
    public function store(Request $request)
    {
        try {
            $request->validate([
                'image' =>'required|image|mimes:jpeg,jpg,png,svg',
                'name' => 'required|string|max:255',
                'score' => 'required|numeric',
                'desc' =>'required|string',
                'status' => 'nullable|boolean',
            ]);

            $badge = new Badge();
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('images/badge', $filename);
                $badge->image = $filename;
            }

            $badge->name = $request->name;
            $badge->description = strip_tags($request->desc);
            $badge->score = $request->score;
            $badge->status = $request->has('status') ? 1 : 0;
            $badge->save();
            if ($request->input('action') == 'add') {
                return redirect()->route('badge.index')->with('success','Badge added successfully');
            } else {
                return redirect()->route('badge.create')->with('success','Badge added successfully');
            }
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while adding the badge: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Data Store Code end-------------------------------

    //---------------------------------- Edit Page Code start-------------------------------
    public function edit($id)
    {
        $badges = Badge::find($id);
        if (!$badges) {
            abort(404);
        }
        return view('admin.badge.edit', compact('badges'));
    }
    //---------------------------------- Edit Page Code end-------------------------------

    //---------------------------------- Update Code start-------------------------------
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'image' => 'image|mimes:jpeg,jpg,png,svg',
                'name' => 'required|string|max:255',
                'score' => 'required|numeric',
                'desc' => 'required|string',
            ]);

            $badge = Badge::findOrFail($id);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('images/badge', $filename);
                if ($badge->image != null) {
                    $existingImagePath = public_path('images/badge/' . $badge->image);
                    if (file_exists($existingImagePath)) {
                        unlink($existingImagePath);
                    }
                }
                $badge->image = $filename;
            }

            $badge->name = $request->input('name');
            $badge->description = strip_tags($request->input('desc'));
            $badge->score = $request->score;
            $badge->status = $request->has('status') ? 1 : 0;
            $badge->save();

            return redirect()->route('badge.index')->with('success','Badge data updated successfully');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while updating the badge: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Update Code end-------------------------------

    //---------------------------------- Data Delete Code start-------------------------------
    public function destroy(string $id)
    {
        try {
            $badges = Badge::find($id);
            $badges->delete();
            return redirect('admin/badge')->with('delete','User deleted successfuly');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while deleting the badge: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Data Delete Code end-------------------------------

    //---------------------------------- Data Selected Delete Code start-------------------------------
    public function bulk_delete(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
            if ($validator->fails()) {
                return back()->with('warning', 'Atleast one item is required to be checked');
            }
            else{
                Badge::whereIn('id',$request->checked)->delete();
                return redirect('admin/badge')->with('delete','Data Delete Successfully');
            }
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while deleting the user: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Data Selected Delete Code end-------------------------------

    //---------------------------------- trash Code start-------------------------------
    public function trash()
    {
        $badges = Badge::onlyTrashed()->get();
        return view('admin.badge.trash', compact('badges'));
    }
    //---------------------------------- trash Code end-------------------------------

    //---------------------------------- trash restore Code start-------------------------------
    public function restore(string $id)
    {
        try{
            $badges = Badge::withTrashed()->find($id);
            if(!is_null($badges)){
                $badges->restore();
            }
            return redirect('admin/badge/trash')->with('success','Trash Data restore Successfully');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while restoring the badge: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- trash restore Code end-------------------------------

    //---------------------------------- Trash data Delete Code start-------------------------------
    public function trashDelete(string $id)
    {
        try{
            $badge = Badge::withTrashed()->find($id);

            if (!is_null($badge) && !empty($badge->image)) {
                $imagePath = public_path('images/badge/' . $badge->image);

                if (file_exists($imagePath)) {
                    unlink($imagePath); // Delete the image file
                }
            }

            if (!is_null($badge)) {
                $badge->forceDelete();
                return redirect('admin/badge/trash')->with('delete', 'Data Deleted Successfully');
            }

            return redirect('admin/badge/trash')->with('delete', 'Trash Data Deleted Successfully');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while deleting the data: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Trash data Delete Code end-------------------------------

    //---------------------------------- Data Selected Delete Code start-------------------------------
    public function trash_bulk_delete(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
            if ($validator->fails()) {
                return back()->with('warning', 'Atleast one item is required to be checked');
            }
            else{
                Badge::whereIn('id',$request->checked)->forceDelete();
                return redirect('admin/badge/trash')->with('delete','Data Delete Successfully');
            }
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while deleting the data: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Data Selected Delete Code end -------------------------------

    //---------------------------------- Badge assign Code start -------------------------------
    public function checkAndAssignBadges($id)
    {
        try {
            $user = User::findOrFail($id);
            \Log::info("Checking badges for user: " . $user->id);

            // Get all badges that the user qualifies for based on score
            $qualifiedBadges = Badge::where('score', '<=', $user->score)->get();

            // Get the IDs of badges the user already has
            $userBadgeIds = $user->badges()->pluck('badges.id')->toArray();

            // Filter out badges the user already has
            $newBadges = $qualifiedBadges->whereNotIn('id', $userBadgeIds);

            \Log::info("Found " . $newBadges->count() . " new badges");

            foreach ($newBadges as $badge) {
                \Log::info("Attempting to attach badge: " . $badge->id . " to user: " . $user->id);

                try {
                    $user->badges()->attach($badge->id, [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    \Log::info("Badge " . $badge->id . " attached successfully to user " . $user->id);

                    $user->notify(new BadgeEarned($badge));

                    \Log::info("Notification sent for badge " . $badge->id);
                } catch (\Exception $e) {
                    \Log::error("Error attaching badge: " . $e->getMessage());
                }
            }
        } catch (\Exception $e) {
            \Log::error("Error in checkAndAssignBadges: " . $e->getMessage());
        }
    }
    //---------------------------------- Badge assign Code end -------------------------------

    //---------------------------------- Badges page for front Code start-------------------------------
    public function badge() {
        $badges = Badge::where('status','1')->get();
        $user = Auth::user();
        $setting = GeneralSetting::first();
        return view('front.badge', compact('badges', 'setting', 'user'));
    }
    //---------------------------------- Badges page for front Code end-------------------------------

    //---------------------------------- Badges report Code start-------------------------------
    public function reports() {
        $badges = Badge::all();
        return view('admin.badge.reports',compact('badges'));
    }
    //---------------------------------- Badges report Code end-------------------------------
}
