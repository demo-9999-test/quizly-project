<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\States;
use App\Models\Country;
use App\Models\Allstate;
use Laracasts\Flash\Flash;

class StateController extends Controller
{
    // ---------------------------------- Show List of Countries Code start -------------------------------
    public function index()
    {
        $countries = Country::get(); // Retrieve all countries
        return view('admin.state.index', compact('countries')); // Pass countries to the view
    }
    // ---------------------------------- Show List of Countries Code end -------------------------------

    // ---------------------------------- Store States for Selected Country Code start -------------------------------
    public function store(Request $request)
    {
        // Validate request
        $this->validate($request, [
            'country_id' => 'required' // Ensure country_id is provided
        ]);

        // Fetch country data and all states related to the country
        $data = Country::where('id', $request->country_id)->first();
        $allstates = Allstate::where('country_id', $data->country_id)->get();
        $states = States::where('country_id', $data->country_id)->first();

        // Check if states for the country already exist
        if ($states == NULL) {
            // Insert states into the States table if they do not exist
            foreach ($allstates as $state) {
                DB::table('states')->insert([
                    'state_id' => $state->id,
                    'name' => $state->name,
                    'country_id' => $state->country_id,
                ]);
            }
            return redirect('admin/state');
        } else {
            Flash::error('Already Exist')->important(); // Show error if states already exist

            return redirect('admin/state');
        }
    }
    // ---------------------------------- Store States for Selected Country Code end -------------------------------

    // ---------------------------------- Show States and Countries Code start -------------------------------
    public function show()
    {
        $countries = Country::get(); // Retrieve all countries
        $stateData = States::orderBy('created_at', 'desc')->get(); // Retrieve all states ordered by creation date
        return view('admin.state.index', compact('countries', 'stateData')); // Pass data to the view
    }
    // ---------------------------------- Show States and Countries Code end -------------------------------

    // ---------------------------------- Add New State Code start -------------------------------
    public function addstate(Request $request)
    {
        // Validate request data
        $data = $this->validate($request, [
            'name' => 'required|unique:allstates,name', // Ensure the state name is unique
        ]);

        // Create a new state in the Allstate table
        $created_state = Allstate::create([
            'name' => $request->name,
            'country_id' => $request->country_id,
        ]);

        if ($created_state) {
            // Create a corresponding entry in the States table
            States::create([
                'name' => $request->name,
                'state_id' => $created_state->id,
                'country_id' => $created_state->country_id,
            ]);
            return redirect('admin/state');
        } else {
            Flash::error('Failed to add data.')->important(); // Show error if the state could not be added

            return redirect('admin/state');
        }
    }
    // ---------------------------------- Add New State Code end -------------------------------

    // ---------------------------------- Delete State Code start -------------------------------
    public function destroy(string $id)
    {
        $states = States::find($id); // Find the state by ID
        $states->delete(); // Delete the state
        return redirect('admin/state'); // Redirect after deletion
    }
    // ---------------------------------- Delete State Code end -------------------------------

    // ---------------------------------- Bulk Delete States Code start -------------------------------
    public function bulk_delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'checked' => 'required', // Ensure at least one item is checked
        ]);

        if ($validator->fails()) {
            return back(); // Return back if validation fails
        } else {
            // Delete states based on the checked IDs
            States::whereIn('id', $request->checked)->delete();
            return redirect('admin/country'); // Redirect after deletion
        }
    }
    // ---------------------------------- Bulk Delete States Code end -------------------------------
}
