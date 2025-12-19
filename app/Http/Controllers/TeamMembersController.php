<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeamMembers;
use Session;
use Illuminate\Support\Facades\Validator;

class TeamMembersController extends Controller
{
    public function __construct()
    {
        // Apply middleware for different permissions
        $this->middleware('permission:team.view', ['only' => ['index', 'show']]);
        $this->middleware('permission:team.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:team.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:team.delete', ['only' => ['destroy', 'bulk_delete']]);
    }

    // ---------------------------------- Show List Code start -------------------------------
    public function index()
    {
        return view('admin.team.index');
    }
    // ---------------------------------- Show List Code end -------------------------------

    // ---------------------------------- Show Create Form Code start -------------------------------
    public function create()
    {
        return view('admin.team.create');
    }
    // ---------------------------------- Show Create Form Code end -------------------------------

    // ---------------------------------- Store New Team Member Code start -------------------------------
    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required',
                'designation' => 'required',
                'image' => 'required|image|mimes:jpeg,png',
                'bio' => 'required',
            ]);

            // Create a new team record with specific fields
            $team = new TeamMembers;
            $team->name = $request->input('name');
            $team->designation = $request->input('designation');
            $team->bio = $request->input('bio');
            $team->status = $request->input('status') ? 1 : 0;

            // Handle the file upload
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('images/team', $filename);
                $team->image = $filename;
            }

            $team->save();

            if ($request->has('create_and_new')) {
                return redirect()->route('members.create')->with('success', 'Data has been added. You can create another record.');
            }

            return redirect('admin/team-members')->with('success', 'Data has been added.');
        }catch (\Exception $e) {
            $errorMessage = 'An error occurred while adding the Team member: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    // ---------------------------------- Store New Team Member Code end -------------------------------

    // ---------------------------------- Show Team Member Details Code start -------------------------------
    public function show(Request $request)
    {
        $team = TeamMembers::orderBy('created_at', 'desc')->paginate(7);
        return view('admin.team.index', compact('team'));
    }
    // ---------------------------------- Show Team Member Details Code end -------------------------------

    // ---------------------------------- Show Edit Form Code start -------------------------------
    public function edit(string $id)
    {
        $team = TeamMembers::find($id);
        if (!$team) {
            return redirect('admin/team-members')->with('error', 'Team not found');
        }
        return view('admin.team.edit', compact('team'));
    }
    // ---------------------------------- Show Edit Form Code end -------------------------------

    // ---------------------------------- Update Team Member Code start -------------------------------
    public function update(Request $request, string $id)
    {
        try{
            $team = TeamMembers::find($id);
            if (!$team) {
                return redirect('admin/team-members')->with('error', 'Team not found.');
            }

            $team->name = $request->input('name');
            $team->designation = $request->input('designation');
            $team->bio = $request->input('bio');
            $team->status = $request->input('status') ? 1 : 0;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('images/team', $filename);

                // Delete existing image if it exists
                if ($team->image != null) {
                    $existingImagePath = public_path('images/team/' . $team->image);
                    if (file_exists($existingImagePath)) {
                        unlink($existingImagePath);
                    }
                }

                $team->image = $filename;
            }

            $team->save();
            return redirect('admin/team-members')->with('success', 'Team member has been updated.');
        }catch (\Exception $e) {
            $errorMessage = 'An error occurred while updating the Team member: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    // ---------------------------------- Update Team Member Code end -------------------------------

    // ---------------------------------- Delete Team Member Code start -------------------------------
    public function destroy($id)
    {
        try{
            $team = TeamMembers::find($id);
            if ($team->image != null) {
                $teamPath = public_path('/images/team/' . $team->image);
                if (file_exists($teamPath)) {
                    unlink($teamPath);
                }
            }
            $team->delete();
            return redirect('admin/team-members')->with('delete', 'Data Deleted Successfully');
        }catch (\Exception $e) {
            $errorMessage = 'An error occurred while deleting the Team member: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    // ---------------------------------- Delete Team Member Code end -------------------------------

    // ---------------------------------- Bulk Delete Code start -------------------------------
    public function bulk_delete(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
            if ($validator->fails()) {
                return back()->with('warning', 'At least one item is required to be checked');
            } else {
                TeamMembers::whereIn('id', $request->checked)->delete();
                return redirect()->back()->with('delete','Data deleted successfully');
            }
        }catch (\Exception $e) {
            $errorMessage = 'An error occurred while deleting the Team member: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    // ---------------------------------- Bulk Delete Code end -------------------------------
}
