<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Laracasts\Flash\Flash;
use Laravolt\Avatar\Avatar;
use App\Models\User;
use App\Models\BattleQuiz;
use App\Models\Allcity;
use App\Models\Allcountry;
use App\Models\Allstate;
use App\Models\SocialMedia;
use Spatie\Permission\Models\Role;
use App\Models\AccountDeletionRequest;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:users.view', ['only' => ['index','show']]);
        $this->middleware('permission:users.create', ['only' => ['create','store','importSave']]);
        $this->middleware('permission:users.edit', ['only' => ['edit', ' update','updateStatus','updateOrder']]);
        $this->middleware('permission:users.delete', ['only' => ['destroy','bulk_delete','trash_bulk_delete','trash','restore','trashDelete']]);
    }
    //---------------------------------- Page View Code start-------------------------------
    public function index()
    {
        return view('admin.users.index');
    }
    //---------------------------------- Page View Code end-------------------------------

    //---------------------------------- Create Page  Code start-------------------------------
    public function create()
    {
        $cities = Allcity::all();
        $states = Allstate::all();
        $countries = Allcountry::all();
        $roles = Role::all();
        return view('admin.users.create', compact('cities', 'states', 'countries','roles'));
    }
    //---------------------------------- Create Page  Code end-------------------------------


    //---------------------------------- Data Store Code start-------------------------------
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'slug' => 'required',
                'email' => 'required|email',
                'mobile' => 'required|numeric',
                'age' => 'required|numeric',
                'role' => 'required',
                'gender' => 'required',
                'password' => 'required',
                'address' => 'required',
                'city' => 'required',
                'state' => 'required',
                'country' => 'required',
                'pincode' => 'required|numeric',
                'image' => 'required|image',
            ]);
                $user = new User;
            $user->name = $request->input('name');
            $user->slug = $request->input('slug');
            $user->email = $request->input('email');
            $user->mobile = $request->input('mobile');
            $user->role = strtoupper(substr($request->input('role'), 0, 1));
            $user->gender = $request->input('gender');
            $user->age = $request->input('age');
            $user->password = bcrypt($request->input('password'));
            $user->status = (int) $request->has('status');
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
                $user->image = $filename;
            } else {
                $avatar = new User;
                $avatar->create($user->name)->toBase64();
            }
            $user->assignRole($request->role);
            $user->save();
            $socialMediaTypes = $request->input('social_media_type', []);
            $socialMediaUrls = $request->input('social_media_url', []);

            $socialMediaData = [];
            foreach ($socialMediaTypes as $key => $type) {
                $url = $socialMediaUrls[$key] ?? null;
                if ($type && $url) {
                    $socialMediaData[] = [
                        'type' => $type,
                        'url' => $url,
                    ];
                }
            }

            foreach ($socialMediaData as $socialMediaEntry) {
                $socialMedia = new SocialMedia($socialMediaEntry);
                $user->socialMedia()->save($socialMedia);
            }

            return redirect('admin/users')->with('success','Data has been added successfully.');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while adding the user: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Data Store Code end-------------------------------

    //---------------------------------- All Data Show Code start-------------------------------
    public function show(Request $request) {
        $users = User::leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->select('users.*', 'roles.name as role_name')
        ->orderBy('users.id', 'desc')
        ->get();
        return view('admin.users.index', compact('users'));
    }
    //---------------------------------- All Data Show Code end-------------------------------

    //---------------------------------- Edit Page Code start-------------------------------
    public function edit(string $id){
        $roles = Role::all();
        $user = User::find($id);
        $socialMediaData = $user->socialMedia;
        if (!$user) {
            Flash::error('user not found')->important();

            return redirect('admin/users');
        }
        return view('admin.users.edit', compact('user', 'socialMediaData','roles'));
    }
    //---------------------------------- Edit Page Code end-------------------------------

    //---------------------------------- Update Code start-------------------------------
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'mobile' => 'required',
                'role' => 'required',
                'address' => 'required',
                'pincode' => 'required',
            ]);
            $user = User::find($id);
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->mobile = $request->input('mobile');
            $user->role = strtoupper(substr($request->input('role'), 0, 1));
            $user->gender = $request->input('gender');
            if ($request->filled('password')) {
                $user->password = bcrypt($request->input('password'));
            }
            $user->status = $request->has('status') ? 1 : 0;
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
            $user->syncRoles([$request->role]);

            $user->save();
            $socialMediaTypes = $request->input('social_media_type', []);
            $socialMediaUrls = $request->input('social_media_url', []);

            $socialMediaData = [];
            foreach ($socialMediaTypes as $key => $type) {
                $url = $socialMediaUrls[$key] ?? null;
                if ($type && $url) {
                    $socialMediaData[] = [
                        'type' => $type,
                        'url' => $url,
                    ];
                }
            }

            // Delete existing social media entries
            $user->socialMedia()->delete();

            // Save new social media entries
            foreach ($socialMediaData as $socialMediaEntry) {
                $socialMedia = new SocialMedia($socialMediaEntry);
                $user->socialMedia()->save($socialMedia);
            }
                return redirect('admin/users')->with('success','User Data has been updated.');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while updating the user: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Update Code End-------------------------------

    //---------------------------------- Data Delete Code start-------------------------------
    public function destroy(string $id){
        try {
            $user = User::find($id);
            $user->delete();
            return redirect('admin/users')->with('delete','User Deleted Successfully');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while deleting the user: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Data Delete Code End-------------------------------

    //---------------------------------- Data Selected Delete Code start-------------------------------
    public function bulk_delete(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
            if ($validator->fails()) {
                return back()->with('warning', 'Atleast one item is required to be checked');
            }
            else{
                User::whereIn('id',$request->checked)->delete();

                return redirect('admin/users')->with('delete','Data Delete Successfully');
            }
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while deleting the user: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }

    public function trash_bulk_delete(Request $request)
{
    try {
        $validator = Validator::make($request->all(), [
            'checked' => 'required|array',
            'checked.*' => 'exists:users,id', // Validate IDs exist in users table
        ]);

        if ($validator->fails()) {
            \Log::warning('Bulk delete validation failed: ' . json_encode($validator->errors()));
            Flash::error('At least one valid user must be selected.')->important();
            return redirect()->route('users.trash');
        }

        $userIds = $request->input('checked', []);
        \Log::info('Bulk delete IDs: ' . json_encode($userIds));

        DB::beginTransaction();

        foreach ($userIds as $userId) {
            $user = User::withTrashed()->find($userId);
            if ($user) {
                // Delete related records
                BattleQuiz::where('user_id', $userId)->delete();
                // Add other related deletions if needed

                // Delete user image
                if ($user->image) {
                    $imagePath = public_path('images/users/' . $user->image);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }

                // Permanently delete the user
                $user->forceDelete();
                \Log::info('User ID ' . $userId . ' permanently deleted.');
            }
        }

        DB::commit();
        Flash::success('Selected users permanently deleted.')->important();
        return redirect()->route('users.trash');
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Bulk delete error: ' . $e->getMessage());
        Flash::error('An error occurred while deleting users: ' . $e->getMessage())->important();
        return redirect()->route('users.trash');
    }
}
    //---------------------------------- Data Selected Delete Code end-------------------------------

    //---------------------------------- Status  Code start-------------------------------
    public function updateStatus(Request $request)
    {
        $user = User::find($request->id);
        $user->status = $request->status;
        $user->save();
        return response()->json(['success' => true, 'message' => 'Status changed successfully.']);
    }
    //---------------------------------- Status  Code end-------------------------------

    //---------------------------------- trash Code start-------------------------------
    public function trash()
    {
        $user = User::onlyTrashed()->get();
        return view('admin.users.trash', compact('user'));
    }
    //---------------------------------- trash Code end-------------------------------


    //---------------------------------- Data restore Code start-------------------------------
    public function restore(string $id)
    {
        try {
            $user = User::withTrashed()->find($id);
            if(!is_null($user)){
                $user->restore();
            }
            return redirect('admin/users/trash')->with('success','Trash Data restored Successfully');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while restoring the user: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Data restore Code End-------------------------------

    //---------------------------------- Trash data Delete Code start-------------------------------
    public function trashDelete(string $id)
{
    try {
        $user = User::withTrashed()->find($id);
        if (!is_null($user)) {
            // Delete related records to avoid foreign key constraints
            \App\Models\BattleQuiz::where('user_id', $id)->delete();
            // Add other related deletions if needed, e.g.:
            // \App\Models\Result::where('user_id', $id)->delete();
            // \App\Models\Comment::where('user_id', $id)->delete();

            // Delete user image if it exists
            if ($user->image) {
                $imagePath = public_path('images/users/' . $user->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Permanently delete the user
            $user->forceDelete();
            
            \Log::info('User ID ' . $id . ' permanently deleted.');
            Flash::success('Trash Data Deleted Successfully')->important();
            return redirect()->route('users.trash');
        }

        \Log::warning('User ID ' . $id . ' not found in trash.');
        Flash::error('User not found in trash.')->important();
        return redirect()->route('users.trash');
    } catch (\Exception $e) {
        \Log::error('Error deleting user ID ' . $id . ': ' . $e->getMessage());
        Flash::error('An error occurred while deleting the user: ' . $e->getMessage())->important();
        return redirect()->route('users.trash');
    }
}

    //----------------------------------Trash data Delete Code start-------------------------------
    public function get_state_country(Request $request)
    {
        $city = Allcity::where('name',$request->city)->first();
        // return $city;
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

    //-------------------------------data import code start--------------------------
    public function import()
    {
        return view('admin.users.import');
    }
    //-------------------------------data import code end--------------------------

    //------------------------------- importFileSave code start-----------------------
    public function importSave(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required',
            ]);

            $file = $request->file('file');
            $fileContents = file($file->getPathname());
            $header = str_getcsv(array_shift($fileContents));
            foreach ($fileContents as $line) {
                $data = array_combine($header, str_getcsv($line));
                User::updateOrInsert(
                    ['email' => $data['email']],
                    [
                        'name' => $data['name'] ?? null,
                        'mobile' => $data['mobile'] ?? null,
                        'role' => $data['role'] ?? null,
                        'gender' => $data['gender'] ?? null,
                        'image' => $data['image'] ?? null,
                        'password' => $data['password'] ?? null,
                        'status' => $data['status'] ?? null,
                    ]
                );
            }

            return redirect('admin/users')->with('success','CSV file imported successfully.');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while importing the file: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //------------------------------- importFileSave code end-----------------------

    //------------------------------- user delete code start-----------------------
    public function user_delete(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
            'reason' => 'required|string',
            'other_reason' => 'required_if:reason,other|max:255',
        ]);

        // Verify the password
        if (!Hash::check($request->password, $request->user()->password)) {
            return redirect()->back()->withErrors(['password' => 'Password does not match our records.']);
        }

        // Handle the reason, use `other_reason` if "Other" is selected
        $reason = $request->reason;
        if ($reason === 'other') {
            $reason = $request->other_reason;
        }

        // Save the account deletion request
        $deleteRequest = new AccountDeletionRequest();
        $deleteRequest->user_id = $request->user()->id;
        $deleteRequest->reason = $reason;
        $deleteRequest->save();

        return redirect()->back()->with('success', 'Your account deletion request has been submitted.');
    }

    //------------------------------- user delete code end-----------------------
    public function login($id)
    {
        $user = User::findOrFail($id);
        Auth::login($user);
        return redirect()->route('user.dashboard')->with('success','Login Successfully.');
    }
}
