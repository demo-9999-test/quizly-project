<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;

class ServiceController extends Controller
{
    public function __construct()
    {
        // Apply middleware for different permissions
        $this->middleware('permission:service.view', ['only' => ['index', 'show']]);
        $this->middleware('permission:service.create', ['only' => ['create', 'store', 'createPermission']]);
        $this->middleware('permission:service.edit', ['only' => ['edit', 'bulkPermission', 'updateStatus', 'updateOrder']]);
        $this->middleware('permission:service.delete', ['only' => ['destroy', 'bulk_delete', 'trash_bulk_delete', 'trash', 'restore', 'trashDelete']]);
    }

    // ---------------------------------- List Services Code start -------------------------------
    public function index()
    {
        $services = Service::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.serviceai.index', compact('services'));
    }
    // ---------------------------------- List Services Code end -------------------------------

    // ---------------------------------- Show Create Form Code start -------------------------------
    public function create()
    {
        return view('admin.serviceai.create');
    }
    // ---------------------------------- Show Create Form Code end -------------------------------

    // ---------------------------------- Store New Service Code start -------------------------------
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $services = new Service;
        $services->name = $request->input('name');
        $services->status = $request->input('status') ? 1 : 0;
        $services->save();
        Flash::success('Service created successfully.');

        return redirect()->route('services.index');
    }
    // ---------------------------------- Store New Service Code end -------------------------------

    // ---------------------------------- Show Edit Form Code start -------------------------------
    public function edit($id)
    {
        $service = Service::find($id);
        return view('admin.serviceai.edit', compact('service'));
    }
    // ---------------------------------- Show Edit Form Code end -------------------------------

    // ---------------------------------- Update Service Code start -------------------------------
    public function update(Request $request, $id)
    {
        $services = Service::find($id);
        $services->name = $request->input('name');
        $services->status = $request->input('status') ? 1 : 0;
        $services->save();
        Flash::success('Service updated successfully.');

        return redirect()->route('services.index');
    }
    // ---------------------------------- Update Service Code end -------------------------------

    // ---------------------------------- Delete Service Code start -------------------------------
    public function destroy(string $id)
    {
        $service = Service::find($id);
        $service->delete();
        Flash::success('Service deleted successfully.');

        return redirect()->route('services.index');
    }
    // ---------------------------------- Delete Service Code end -------------------------------

    // ---------------------------------- Bulk Delete Code start -------------------------------
    public function bulk_delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);
        if ($validator->fails()) {
            Flash::error('At least one item is required to be checked')->important();

            return back();
        } else {
            Service::whereIn('id', $request->checked)->delete();
            Flash::success('Service deleted successfully.');

            return redirect('admin/services');
        }
    }
    // ---------------------------------- Bulk Delete Code end -------------------------------

    // ---------------------------------- Update Status Code start -------------------------------
    public function updateStatus(Request $request)
    {
        $services = Service::find($request->id);
        $services->status = $request->status;
        $services->save();
        return response()->json(['message' => 'Status changed successfully'], 200);
    }
    // ---------------------------------- Update Status Code end -------------------------------
}
