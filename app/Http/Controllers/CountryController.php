<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Country;
use App\Models\Allcountry;
use Laracasts\Flash\Flash;

class CountryController extends Controller
{
    //--------------------------- index code start --------------------------
    public function index()
    {
        $countries = Allcountry::get();
        return view('admin.country.index',compact('countries'));
    }
    //--------------------------- bulk_delete code end --------------------------

    //--------------------------- store code start --------------------------
    public function store(Request $request)
    {
        $this->validate($request, [
            'country' => 'required',
        ]);
        $existingCountry = Country::where('country_id', $request->country)->first();
        if (!$existingCountry) {
            $data = Allcountry::where('id', $request->country)->first();
            if ($data) {
                DB::table('countries')->insert([
                    'country_id' => $data->id,
                    'iso' => $data->iso,
                    'name' => $data->name,
                    'nicename' => $data->nicename,
                    'iso3' => $data->iso3,
                    'numcode' => $data->numcode,
                    'created_at' => now(),
                ]);
                Flash::success('Data has been added.')->important();

                return redirect('admin/country');
            } else {
                Flash::error('data invaild')->important();

                return redirect('admin/country');
            }
        } else {
            Flash::error('Already Exist')->important();
            return redirect('admin/country');
        }
    }
    //--------------------------- store code end --------------------------

    //--------------------------- store code start --------------------------
    public function show()
    {
        $countries = Allcountry::get();
        $countryData = Country::orderBy('created_at','desc')->get();
        return view('admin.country.index',compact('countries','countryData'));
    }
    //--------------------------- store code end --------------------------

    //--------------------------- edit code start --------------------------
    public function edit(string $id)
    {
        $country = Allcountry::get();
        $countryData = Country::find($id);
        if (!$countryData) {
            Flash::error('country not found')->important();
            return redirect('admin/country');
        }
        return view('admin.country.edit', compact('countryData','country'));
    }
    //--------------------------- edit code end --------------------------

    //--------------------------- update code start --------------------------
    public function update(Request $request, $id)
    {
        $existingCountry = Country::where('country_id', $request->country)->first();

        if ($existingCountry === null) {
            $data = Allcountry::find($request->country);

            if ($data) {
                DB::table('countries')->where('id', $id)->update([
                    'country_id' => $data->id,
                    'iso' => $data->iso,
                    'name' => $data->name,
                    'nicename' => $data->nicename,
                    'iso3' => $data->iso3,
                    'numcode' => $data->numcode,
                ]);
                Flash::success('Data has been updated.')->important();

                return redirect('admin/country');
            } else {
                Flash::error('Invalid data.')->important();

                return redirect('admin/country');
            }
        } else {
            Flash::error('Already Exist')->important();
            return redirect('admin/country');
        }
    }
    //--------------------------- update code end --------------------------

    //--------------------------- destroy code start --------------------------
    public function destroy(string $id)
    {
        $countryData = Country::find($id);
        $countryData->delete();
        Flash::error('Data Delete Successfully')->important();

        return redirect('admin/country');
    }
    //--------------------------- destroy code end --------------------------

    //--------------------------- bulk_delete code start --------------------------
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
            Country::whereIn('id',$request->checked)->delete();
            Flash::error('Data Delete Successfully')->important();
            return redirect('admin/country');
        }
    }
    //--------------------------- bulk_delete code end --------------------------
}
