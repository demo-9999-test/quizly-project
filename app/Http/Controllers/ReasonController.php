<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reason;
use Illuminate\Support\Facades\Validator;
class ReasonController extends Controller
{
    public function __construct()
    {
        // Define middleware for different actions based on permissions
        $this->middleware('permission:reason.view', ['only' => ['index', 'show']]);
        $this->middleware('permission:reason.create', ['only' => ['store']]);
        $this->middleware('permission:reason.edit', ['only' => ['update']]);
        $this->middleware('permission:reason.delete', ['only' => ['delete', 'bulk_delete', 'trash_bulk_delete', 'trash', 'restore', 'trashDelete']]);
    }

    /**
     * Display a listing of all reasons
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $reason = Reason::all();
        return view('admin.reasons.index', compact('reason'));
    }

    /**
     * Store a newly created reason in storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'reason' => 'required|string|max:255',
                'status' => 'sometimes|boolean',
            ]);

            // Create and save new Reason
            $reason = new Reason();
            $reason->reason = $request->input('reason');
            $reason->status = $request->has('status') ? 1 : 0;
            $reason->save();

            return redirect()->back()->with('success', 'Reason added successfully.');
        }
        catch (\Exception $e) 
        {
            $errorMessage = 'An error occurred while adding the reason: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }

    /**
     * Show the form for editing the specified reason
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $reason = Reason::findOrFail($id);
        return view('admin.reasons.edit', compact('reason'));
    }

    /**
     * Update the specified reason in storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'reason' => 'required|string|max:255',
                'status' => 'sometimes|boolean',
            ]);

            // Find and update the Reason
            $reason = Reason::findOrFail($id);
            $reason->reason = $request->input('reason');
            $reason->status = $request->has('status') ? 1 : 0;
            $reason->save();

            return redirect()->route('reason.show')->with('success', 'Reason updated successfully.');
        }
        catch (\Exception $e) 
        {
            $errorMessage = 'An error occurred while updating the reason: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $data = Reason::findOrFail($id);
            $data->status = $request->has('approved') ? 1 : 0;
            $data->save();

            return redirect()->back()->with('success', 'Status updated successfully');
        }
        catch (\Exception $e) 
        {
            $errorMessage = 'An error occurred while updating the status: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    /**
     * Remove the specified reason from storage
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $reason = Reason::findOrFail($id);
            $reason->delete();

            return redirect()->back()->with('delete', 'Reason deleted successfully.');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while deleting the reason: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }

    /**
     * Bulk delete selected reasons
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bulk_delete(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);

            if ($validator->fails()) {
                return back()->with('warning', 'At least one item is required to be checked');
            } else {
                Reason::whereIn('id', $request->checked)->delete();
                return redirect('admin/reasons')->with('delete', 'Data Delete Successfully');
            }
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while deleting the reasons: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }

    /**
     * Display a listing of trashed reasons
     *
     * @return \Illuminate\View\View
     */
    public function trash()
    {
        $reason = Reason::onlyTrashed()->get();
        return view('admin.reasons.trash', compact('reason'));
    }

    /**
     * Restore a trashed reason
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        try {
            $reason = Reason::withTrashed()->find($id);
            if (!is_null($reason)) {
                $reason->restore();
            }
            return redirect('admin/reasons/trash')->with('success', 'Trash Data restore Successfully');
        }catch (\Exception $e) {
            $errorMessage = 'An error occurred while restoring the reasons: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }

    /**
     * Permanently delete a trashed reason
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function trashDelete($id)
    {
        try {
            $reason = Reason::withTrashed()->find($id);
            if (!is_null($reason)) {
                $reason->forceDelete();
                return redirect('admin/reasons/trash')->with('delete', 'Data Delete Successfully');
            }
            return redirect('admin/quiz/trash')->with('delete', 'Data Delete Successfully');
        } catch (\Exception $e) {
            $errorMessage = 'An error occurred while deleting the reasons: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }

    /**
     * Bulk delete selected trashed reasons permanently
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function trash_bulk_delete(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);

            if ($validator->fails()) {
                return back()->with('warning', 'At least one item is required to be checked');
            } else {
                Reason::whereIn('id', $request->checked)->forceDelete();
                return redirect('admin/reasons/trash')->with('delete', 'Data Delete Successfully');
            }
        } catch (\Exception $e) {
            $errorMessage = 'An error occurred while deleting the reasons: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
}
