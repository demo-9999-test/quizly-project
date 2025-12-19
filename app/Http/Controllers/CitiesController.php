<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Allcity;
use App\Models\States;
use App\Models\Cities;
use App\Models\Country;
use Laracasts\Flash\Flash;
use Yajra\DataTables\DataTables;


class CitiesController extends Controller
{
    //-------------------------  index code start -------------------------
    public function index()
    {
        $allstates = States::get();
        return view('admin.cities.index',compact('allstates'));
    }
    //-------------------------  index code end -------------------------

    //-------------------------  store code start -------------------------
    public function store(Request $request)
    {
        $data = States::where('state_id', $request->state_id)->first();
        $allcities = Allcity::where('state_id', $data->state_id)->get();
        $existingCities = Cities::where('state_id', $data->state_id)->get();
        if ($existingCities->isEmpty()) {
            foreach ($allcities as $city) {
                Cities::create([
                    'name' => $city->name,
                    'state_id' => $city->state_id,
                    'country_id' => $data->country_id,
                ]);
            }
            Flash::success('Data has been added.')->important();

            return redirect('admin/cities');
        } else {
            Flash::error('Already Exist')->important();

            return redirect('admin/cities');
        }
    }
    //-------------------------  store code end -------------------------

    //-------------------------  show code start -------------------------
    public function show()
    {
        $allstates = States::get();
        $allcities = Cities::orderBy('created_at', 'desc')->get();
        $allcountry = Country::get();
        return view('admin.cities.index',compact('allstates','allcities','allcountry'));
    }
    //-------------------------  store code end -------------------------

    //-------------------------  addcity code start -------------------------
    public function addcity(Request $request)
    {
        $this->validate($request, [
            'state_id' => 'required',
            'name' => 'required',
        ]);
        $data = States::where('state_id', $request->state_id)->first();
        if ($data) {
            Cities::create([
                'name' => $request->name,
                'state_id' => $data->state_id,
                'country_id' => $data->country_id,
            ]);
            Flash::success('Data has been added.')->important();
            return redirect('admin/cities');
        }
        Flash::error('Failed to add data.')->important();

        return redirect('admin/cities');
    }
    //-------------------------  addcity code end -------------------------

    //-------------------------  destroy code start -------------------------
    public function destroy(string $id)
    {
        $cities = Cities::find($id);
        $cities->delete();
        Flash::error('Data Delete Successfully')->important();

        return redirect('admin/cities');
    }
    //-------------------------  destroy code end -------------------------

    //-------------------------  bulk delete code start -------------------------
    public function bulk_delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);
        if ($validator->fails()) {
            Flash::error('Atleast one item is required to be checked')->important();

            return back();
        }
        else{
            Cities::whereIn('id',$request->checked)->delete();
            Flash::success('Data Delete Successfully')->important();
            return redirect('admin/cities');
        }
    }
    //-------------------------  bulk delete code end -------------------------

    //-------------------------  get all cities data code start -------------------------
    public function getCitiesData()
    {
        $allcities = Cities::all(); // Assuming City is your Eloquent model for cities

        return DataTables::of($allcities)
            ->addColumn('action', function ($city) {
                // Add your action buttons here
                return view('admin.cities.action', compact('city'))->render();
            })
            ->rawColumns(['action']) // Ensure HTML is not escaped in action column
            ->make(true);
    }
    //-------------------------  get all cities data code end -------------------------

}
