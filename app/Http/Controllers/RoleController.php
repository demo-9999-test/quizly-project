<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use HasRoles;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:roles.view', ['only' => ['index','show']]);
        $this->middleware('permission:roles.create', ['only' => ['create','store']]);
        $this->middleware('permission:roles.edit', ['only' => ['edit', ' update','updateStatus','updateOrder']]);
        $this->middleware('permission:roles.delete', ['only' => ['destroy','bulk_delete','trash_bulk_delete','trash','restore','trashDelete']]);
    }

    //---------------------------------- Page View Code start-------------------------------
    public function index()
    {
        return view('admin.roles.index');
    }
    //---------------------------------- Page View Code end-------------------------------

    //---------------------------------- Create Page  Code start-------------------------------
    public function create()
    {
        if (config('app.demolock') == 1) {
            return back()->with('error','Demo mode is enabled. Data cannot be updated.');
        }

        $permissions = Permission::all();
        $custom_permissions = [];

        foreach ($permissions as $permission) {
            $key = substr($permission->name, 0, strpos($permission->name, '.'));

            if (str_starts_with($permission->name, $key)) {
                $custom_permissions[$key][] = $permission;
            }
        }

        return view('admin.roles.create', compact('custom_permissions'));
    }
    //---------------------------------- Create Page  Code end-------------------------------

    //---------------------------------- Data Store Code start-------------------------------
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'permissions' => 'array',
            ]);

            if (Role::where('name', $request->input('name'))->exists()) {
                return redirect()->back()->with('error','Role already exists.')->withInput();
            }

            // Create a new role
            $role = new Role;
            $role->name = $request->input('name');
            $role->guard_name = 'web';
            $role->save();

            // Attach selected permissions to the role manually
            if ($request->has('permissions')) {
                foreach ($request->input('permissions') as $permissionId) {
                    DB::table('role_has_permissions')->insert([
                        'role_id' => $role->id,
                        'permission_id' => $permissionId,
                    ]);
                }
            }
            return redirect('admin/roles')->with('success','Role created successfully.');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while adding the role: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Data Store Code end-------------------------------

    //---------------------------------- All Data Show Code start-------------------------------

        public function show(Request $request)
        {
            $roles = Role::orderBy('id')->paginate(10);
            return view('admin.roles.index', compact('roles'));
        }
    //---------------------------------- All Data Show Code end-------------------------------

    //---------------------------------- Edit Page Code start-------------------------------
    public function edit(string $id)
    {
        $role = Role::find($id);
        $permissions = Permission::all();
        $custom_permissions = [];

        foreach ($permissions as $permission) {
            $key = substr($permission->name, 0, strpos($permission->name, '.'));

            if (str_starts_with($permission->name, $key)) {
                $custom_permissions[$key][] = $permission;
            }
        }

        // Get the IDs of the existing permissions for the role
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('admin.roles.edit', compact('role', 'custom_permissions', 'rolePermissions'));
    }
    //---------------------------------- Edit Page Code end-------------------------------

    //---------------------------------- Update Code start-------------------------------
        public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'permissions' => 'array',
        ]);


        if ($request->name !== $request->input('name') && Role::where('name', $request->input('name'))->exists()) {
            return redirect()->back()->with('error','Role name already exists.');
        }

        $role = Role::findOrFail($id);

        // Update the role attributes
        $role->name = $request->input('name');
        $role->guard_name = 'web';
        $role->save();

        // Manually update the permissions for the role
        if ($request->has('permissions')) {
            // Remove existing permissions for the role
            DB::table('role_has_permissions')->where('role_id', $role->id)->delete();

            // Insert new permissions for the role
            foreach ($request->input('permissions') as $permissionId) {
                DB::table('role_has_permissions')->insert([
                    'role_id' => $role->id,
                    'permission_id' => $permissionId,
                ]);
            }
        } else {
            // If no permissions are selected, remove all existing permissions for the role
            DB::table('role_has_permissions')->where('role_id', $role->id)->delete();
        }


        return redirect('admin/roles')->with('success','Role updated successfully.');
    }
    //---------------------------------- Update Code End-------------------------------

    //---------------------------------- Data Delete Code start-------------------------------
    public function destroy(string $id)
    {
        $role = Role::find($id);
        // Detach all associated permissions
        $role->permissions()->detach();

        // Delete the role
        $role->delete();
        return redirect('admin/roles')->with('delete','Role and associated permissions deleted successfully.');
    }
    //---------------------------------- Data Delete Code End-------------------------------

    //---------------------------------- Data Selected Delete Code start-------------------------------
    public function bulk_delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('warning', 'Atleast one item is required to be checked');
        }
        else{
            Role::whereIn('id',$request->checked)->delete();
            return redirect('admin/roles')->with('status','Data Delete Successfully');
        }
    }
    //---------------------------------- Data Selected Delete Code end-------------------------------
}
