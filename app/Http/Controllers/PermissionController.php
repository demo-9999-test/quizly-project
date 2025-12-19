<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:permission.view', ['only' => ['index','show']]);
        $this->middleware('permission:permission.create', ['only' => ['create','store','createPermission']]);
        $this->middleware('permission:permission.edit', ['only' => ['edit', ' bulkPermission','updateStatus','updateOrder']]);
        $this->middleware('permission:permission.delete', ['only' => ['destroy','bulk_delete','trash_bulk_delete','trash','restore','trashDelete']]);
    }

    public function create(){
        return view('admin.permission.create');
    }

    //---------------------------------- Data Store Code start-------------------------------
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $permissionName = $request->input('name');

        if (Permission::where('name', $permissionName)->exists()) {
            Flash::error('Permission already exists.')->important();
            return back();
        }

        $permission = new Permission;
        $permission->name = $permissionName;
        $permission->guard_name = 'web';
        $permission->save();

        Flash::success('Data has been added successfully.')->important();
        return redirect('admin/permission');
    }
    //---------------------------------- Data Store Code end-------------------------------

    //-----------------------------------  createPermission code start -------------------
    public function createPermission(Request $request){
        $permissionName = $request->input('name');

        if (Permission::where('name', $permissionName)->exists()) {
            Flash::error('Permission already exists.')->important();
            return back();
        }

        Permission::create([
            'name' => $permissionName,
        ]);

        Flash::success('Permission created successfully.')->important();
        return back();
    }
    //-----------------------------------  createPermission code end -------------------

    //-----------------------------------  bulkPermission code start -------------------
    public function bulkPermission(Request $request){
        $permissions = ['view', 'create', 'edit', 'delete'];
        $baseName = $request->input('name');
        $alreadyExists = false;

        foreach ($permissions as $perm) {
            $permissionName = $baseName . '.' . $perm;
            if (Permission::where('name', $permissionName)->exists()) {
                $alreadyExists = true;
            }
        }

        if ($alreadyExists) {
            Flash::error('One or more permissions already exist.')->important();
            return back();
        }

        foreach ($permissions as $perm) {
            Permission::create([
                'name' => $baseName . '.' . $perm,
            ]);
        }

        Flash::success('Permissions created successfully.')->important();
        return back();
    }
    //-----------------------------------  bulkPermission code end -------------------
}
