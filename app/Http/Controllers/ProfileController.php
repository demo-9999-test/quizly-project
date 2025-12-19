<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Allcity;
use App\Models\Allcountry;
use App\Models\Allstate;
use App\Models\SocialMedia;
use App\Models\Affiliate;
use App\Models\FAQ;
use App\Models\Bookmark;
use App\Models\GeneralSetting;
use App\Models\Packages;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Storage;
use App\Models\Reason;

class ProfileController extends Controller
{
    //---------------------------------- Page View Code start-------------------------------
    public function index()
    {
        $profile = Auth::user();
        $socialMedia = SocialMedia::where('user_id', $profile->id)->get();
        $cities = Allcity::all();
        $states = Allstate::all();
        $countries = Allcountry::all();
        return view('admin.profile', compact('profile', 'socialMedia','cities', 'states', 'countries'));
    }
    //---------------------------------- Page View Code end-------------------------------

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->mobile = $request->input('mobile');
        $user->gender = $request->input('gender');
        $user->desc = $request->input('desc');
        $user->address = $request->input('address');
        $user->city = $request->input('city');
        $user->state = $request->input('state');
        $user->country = $request->input('country');
        $user->pincode = $request->input('pincode');
        if ($request->hasFile('image')) {
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $file->move('images/users', $filename);
        if ($user->image != null) {
            $existingImagePath = public_path('images/users/' . $user->image);
            if (file_exists($existingImagePath)) {
                unlink($existingImagePath);
            }
        }
        $user->image = $filename;
    }
        $user->save();
        $socialMediaData = [];
        foreach ($request->input('social_media_type') as $key => $type) {
            $url = $request->input('social_media_url')[$key];
            if ($type && $url) {
                $socialMediaData[] = [
                    'type' => $type,
                    'url' => $url,
                ];
            }
        }
        $user->socialMedia()->delete();
        foreach ($socialMediaData as $socialMediaEntry) {
            $socialMedia = new SocialMedia($socialMediaEntry);
            $user->socialMedia()->save($socialMedia);
        }
        Flash::success('Data has been updated.')->important();
        return redirect('admin/profile');
    }

    // ---------get country code start---------------------
    public function get_state_country(Request $request)
    {
        $city = Allcity::where('name',$request->city)->first();
        if($city){
            $state = Allstate::where('id',$city->state_id)->first();
            $country = Allcountry::where('id',$city->country_id)->first();
            if($state && $country){
                $data['status'] = "True";
                $data['city_id'] = $city->name;
                $data['state'] = $state->name;
                $data['state_id'] = $state->name;
                $data['country'] = $country->name;
                $data['country_id'] = $country->name;
            } else {
                $data['status'] = "False";
                $data['msg'] = "State And Country Not Found";
            }
        } else {
            $data['status'] = "False";
            $data['msg'] = "City Not Found";
        }
        return response()->json($data);
    }
    // ---------get country code end---------------------

    // ------------password update code start-----------
    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);
        $user = auth()->user();
        if (!Hash::check($request->old_password, $user->password)) {
            Flash::error('Old password is incorrect')->important();

            return redirect()->back();
        }
        $user->update(['password' => bcrypt($request->password)]);
        Flash::success('Password updated successfully')->important();

        return redirect()->route('profile.index');
    }
    // ------------password update code end-----------

    // ------------ front profile code start-----------
    public function front_profile() 
    {
        $user =  Auth::user();
        $affiliate = Affiliate::first();
        $socialMedia = SocialMedia::where('user_id', auth()->id())->get();
        $faq = FAQ::where('status','1')->get();
        $bookmark = Bookmark::all();
        $badges = $user->badges;
        $setting = GeneralSetting::first();
        $plan = Packages::orderBy('preward', 'asc')->get();
        $reasons = Reason::where('status',1)->get();
        return view('front.profile',compact('user','affiliate','faq','bookmark','setting','plan','badges','reasons','socialMedia'));
    }
    // ------------ front profile code end-----------

    // ------------ front profile urlupdate code start-----------
    public function updateSocialMediaUrls(Request $request, $id)
    {
        try{
            $validatedData = $request->validate([
                'facebook' => 'nullable|url',
                'instagram' => 'nullable|url',
                'linkedIn' => 'nullable|url',
                'twitter' => 'nullable|url',
            ]);

            foreach ($validatedData as $type => $url) {
                SocialMedia::updateOrCreate(
                    [
                        'user_id' => $id,
                        'type' => $type,
                    ],
                    [
                        'url' => $url ?: null,
                    ]
                );
            }

            return redirect()->back()->with('success', 'Social media URLs updated successfully.');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while updating URL: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }


    // ------------ front profile urlupdate code end-----------

    // ------------ front user image upload code start-----------
    public function upload_image(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/users'), $filename);

            if ($user->image) {
                $oldImagePath = public_path('images/users/' . $user->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $user->image = $filename;
            $user->save();

            return response()->json(['success' => true, 'message' => 'Image uploaded successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'No image file found.']);
    }
    // ------------ front user image upload code end-----------

    // ------------ front user image remove code start-----------
    public function remove_image(Request $request)
    {
        $user = Auth::user();
        if ($user->image) {
            $imagePath = public_path('images/users/' . $user->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $user->image = null;
            $user->save();
            return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'No image found.']);
    }
    // ------------ front user image delete code end-----------

    // ------------ front store user front settings code start-----------
    public function user_settings_store(Request $request, $id)
    {
        $user = User::find($id);

        $user->update([
            'name' => $request->input('name'),
            'slug' => $request->input('Username'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'country' => $request->input('country'),
            'age' => $request->input('age'),
            'desc' => $request->input('desc'),
            'show_mobile' => $request->has('show_mobile'),
            'show_email' => $request->has('show_email'),
        ]);

        return redirect('/profile')->with('success', 'Profile updated successfully');
    }
    // ------------ store user front settings code end-----------

    // ------------ update front user password code end-----------
    public function update_password (Request $request)
    {
        try{
        $request->validate([
            'old_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    return $fail(__('The old password is incorrect.'));
                }
            }],
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->back()->with('success', 'Password changed successfully.');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while updating your password: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    // ------------ update front user password code end-----------
}
