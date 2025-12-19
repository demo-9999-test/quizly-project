<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Coupon;
use Laracasts\Flash\Flash;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:coupon.view', ['only' => ['index','show']]);
        $this->middleware('permission:coupon.create', ['only' => ['store']]);
        $this->middleware('permission:coupon.edit', ['only' => ['edit', ' update']]);
        $this->middleware('permission:coupon.delete', ['only' => ['destroy','bulk_delete']]);
    }

//---------------------------------- Page View Code start-------------------------------
    public function index()
    {
     return view('admin.coupon.index');
    }
//---------------------------------- Page View Code end-------------------------------

//---------------------------------- Data Store Code start-------------------------------

    public function store(Request $request)
    {
        try{
            $request->validate([
                'coupon_code' => 'required',
                'discount_type' => 'required|in:fix,percentage',
                'limit' => 'required|integer',
                'min_amount' => 'required|numeric',
                'max_amount' => 'nullable|numeric',
                'expiry_date' => 'required|date',
                'start_date' => 'required|date|after_or_equal:today',
                'fixed_amount' => 'required_if:discount_type,fix|numeric|nullable',
                'percentage' => 'required_if:discount_type,percentage|numeric|nullable|between:0,100',
            ]);

            $coupon = new Coupon;
            $coupon->coupon_code = $request->input('coupon_code');
            $coupon->discount_type = $request->input('discount_type');

            if ($request->input('discount_type') === 'fix') {
                $coupon->amount = $request->input('fixed_amount');
            } else {
                $coupon->amount = $request->input('percentage');
            }

            $coupon->min_amount = $request->input('min_amount');
            $coupon->max_amount = $request->input('max_amount');
            $coupon->start_date = $request->input('start_date');
            $coupon->expiry_date = $request->input('expiry_date');
            $coupon->limit = $request->input('limit');
            $coupon->code_display = $request->input('code_display') ? 1 : 0;
            $coupon->active_user = $request->input('active_user') ? 1 : 0;
            $coupon->save();

            return redirect('admin/coupon')->with('succes','Coupon has been added.');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while adding the Coupon: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
//---------------------------------- Data Store Code end-------------------------------
//---------------------------------- All Data Show Code start-------------------------------
    public function show(Request $request)
    {
        $coupon = Coupon::orderBy('created_at','desc')->paginate(10);
        return view('admin.coupon.index', compact('coupon'));
    }
//---------------------------------- All Data Show Code end-------------------------------

//---------------------------------- Edit Page Code start-------------------------------


public function edit(string $id)
{
    $coupon = Coupon::find($id);
    if (!$coupon) {
        Flash::error('blog not found')->important();

        return redirect('admin/coupon');
    }
    return view('admin.coupon.edit', compact('coupon'));
}
//---------------------------------- Edit Page Code end-------------------------------

//---------------------------------- Update Code start-------------------------------

public function update(Request $request, string $id)
{
    try{
        $coupon = Coupon::find($id);
        if (!$coupon) {
            Flash::error('coupon not found.')->important();
            return redirect('admin/coupon');
        }
        $coupon->coupon_code = $request->input('coupon_code');
            $coupon->discount_type = $request->input('discount_type');
            $coupon->amount = $request->input('amount');
            $coupon->min_amount = $request->input('min_amount');
            $coupon->max_amount = $request->input('max_amount');
            $coupon->start_date = $request->input('start_date');
            $coupon->expiry_date = $request->input('expiry_date');
            $coupon->limit = $request->input('limit');
            $coupon->code_display = $request->input('code_display') ? 1 : 0;
            $coupon->active_user = $request->input('active_user') ? 1 : 0;
            $coupon->save();

        return redirect('admin/coupon')->with('success','Coupon has been updated.');
    }
    catch (\Exception $e) {
        $errorMessage = 'An error occurred while updating the Coupon: ' . $e->getMessage();
        return back()->with('error', $errorMessage)->withInput();
    }
}

//---------------------------------- Update Code End-------------------------------


//---------------------------------- Data Delete Code start-------------------------------

public function destroy(string $id)
{
    try{
        $coupon = coupon::find($id);
        $coupon->delete();

        return redirect('admin/coupon')->with('delete','Data Delete Successfully');
    }
    catch (\Exception $e) {
        $errorMessage = 'An error occurred while deleting the Coupon: ' . $e->getMessage();
        return back()->with('error', $errorMessage)->withInput();
    }
}
//---------------------------------- Data Delete Code End-------------------------------


//---------------------------------- Data Selected Delete Code start-------------------------------

public function bulk_delete(Request $request)
{
    try{
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);
        if ($validator->fails()) {


            return back()->with('warning','Atleast one item is required to be checked');
        }
        else{
            coupon::whereIn('id',$request->checked)->delete();
            return redirect('admin/coupon')->with('delete','Data Delete Successfully');
        }
    }
    catch (\Exception $e) {
        $errorMessage = 'An error occurred while deleting the Coupon: ' . $e->getMessage();
        return back()->with('error', $errorMessage)->withInput();
    }
}

//---------------------------------- Data Selected Delete Code end-------------------------------

}
