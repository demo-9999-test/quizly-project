<?php

namespace App\Http\Controllers;

use App\Models\ManualPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;

class ManulPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manual_payment.view', ['only' => ['index','show']]);
        $this->middleware('permission:manual_payment.create', ['only' => ['create','store','importSave']]);
        $this->middleware('permission:manual_payment.edit', ['only' => ['edit', ' update','updateStatus','updateOrder']]);
        $this->middleware('permission:manual_payment.delete', ['only' => ['destroy','bulk_delete','trash_bulk_delete','trash','restore','trashDelete']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payment = ManualPayment::all();
        return view('admin.manual-payment.index', compact('payment'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.manual-payment.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'gateway_name' => 'required|string|max:255',
            'logo' => 'required|image',
        ]);

        $payment = new ManualPayment;
        $payment->gateway_name = $request->input('gateway_name');
        $payment->status = $request->has('status') ? 1 : 0;
        $payment->details = $request->input('details');
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('images/manual-payment', $filename);
            $payment->image = $filename;
        }
        $payment->save();
        Flash::success('Manual payment created successfully.');
        return redirect()->route('manual.show');
    }

    /**
     * Display the specified resource.
     */
    public function show(ManualPayment $manualPayment)
    {
        return view('admin.manual-payment.show', compact('manualPayment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $payment = ManualPayment::findOrFail($id); // Assuming Gateway is your model name
    return view('admin.manual-payment.edit', compact('payment'));
}
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'gateway_name' => 'nullable|string|max:255',
            'logo' => 'nullable|image',
        ]);

        $payment = ManualPayment::find($id);
        $payment->gateway_name = $request->input('gateway_name');
        $payment->status = $request->has('status') ? 1 : 0;
        $payment->details = $request->input('details');
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('images/manual-payment', $filename);
            $payment->image = $filename;
        }
        $payment->save();
        Flash::success('Manual payment Update successfully.');
        return redirect()->route('manual.show');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    // Find the manual payment by id
    $payment = ManualPayment::find($id);

    // Check if the payment exists
    if (!$payment) {
        // Flash an error message if the payment is not found
        Flash::error('Manual payment not found.');
        return redirect()->route('manual-payments.index');
    }

    // Delete the payment
    $payment->delete();

    // Flash a success message
    Flash::success('Manual payment deleted successfully.');
    // Redirect with success message
    return redirect()->route('manual-payments.index');
}

    public function updateStatus(Request $request)
    {
        $payment = ManualPayment::find($request->id);
        $payment->status = $request->status;
        $payment->save();
        return response()->json(['success' => true, 'message' => 'Status changed successfully.']);
    }

    //---------------------------------- Data Selected Delete Code start-------------------------------

    public function bulk_delete(Request $request){
        // return $request;
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);
        if ($validator->fails()) {
            Flash::warning('Atleast one item is required to be checked');
            return back();
        }
        else{
            ManualPayment::whereIn('id',$request->checked)->delete();
            Flash::success('Data Delete Successfully')->important();

            return redirect('admin/manual_payment');
        }
    }
//---------------------------------- Data Selected Delete Code end-------------------------------
}
