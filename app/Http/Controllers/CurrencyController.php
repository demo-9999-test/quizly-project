<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Torann\Currency\Facades\Currency;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class CurrencyController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:currency.view', ['only' => ['index','show']]);
        $this->middleware('permission:currency.create', ['only' => ['store','exchangestore']]);
        $this->middleware('permission:currency.edit', ['only' => ['updateStatus','update_currency']]);
        $this->middleware('permission:currency.delete', ['only' => ['destroy']]);
    }

    public function index(){
        return view('admin.currency.index');
    }

//---------------------------------- Data Store Code start-------------------------------
    public function store(Request $request)
    {
        try{
            $request->validate([
                'code' => 'required|alpha|size:3|unique:currencies'
            ]);
            Artisan::call('currency:manage add '.$request->code);
            Artisan::call('currency:update -o');

            return back()->with('success','Currency added successfully');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while adding currency: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }

    public function exchangestore(Request $request)
    {
        $env_update = DotenvEditor::setKeys([
            'OPEN_EXCHANGE_RATE_KEY' => $request->input('OPEN_EXCHANGE_RATE_KEY'),
        ]);
        $env_update->save();
        return redirect('admin/currency')->with('success','Data has been added.');
    }
//---------------------------------- Data Store Code end-------------------------------

//---------------------------------- All Data Show Code start-------------------------------
    public function show()
    {
        $currency = DB::table('currencies')->get();
        $openKey = env('OPEN_EXCHANGE_RATE_KEY');
        return view('admin.currency.index', compact('openKey', 'currency'));
    }
//---------------------------------- All Data Show Code end-------------------------------


//---------------------------------- Status  Code start-------------------------------

public function updateStatus(Request $request)
{
    $currencies = DB::table('currencies')->get();
    foreach ($currencies as $currency) {
        if ($currency->id == $request->id) {
            DB::table('currencies')->where('id', $currency->id)->update(['default' => 1]);
        } else {
            DB::table('currencies')->where('id', $currency->id)->update(['default' => 0]);
        }
    }
    return redirect('admin/currency')->with('success','Status change successfully.');
}
//---------------------------------- Status  Code end-------------------------------

//---------------------------------- Data Delete Code start-------------------------------
public function destroy(string $id)
{
    $currency = DB::table('currencies')->where('id', $id)->first();
    if($currency->default == 1)
    {
        Flash::error('You can\'t delete default currency!')->important();
        return back();
    }
    if ($currency) {
        DB::table('currencies')->where('id', $id)->delete();
        return redirect('admin/currency')->with('success','Data Delete Successfully');
    } else {
        return redirect('admin/currency')->with('error','Record not found');
    }
}
//---------------------------------- Data Delete Code End-------------------------------

//---------------------------------- currencySwitch Code start-------------------------------
public function currencySwitch($symbol)
{
    $currency = DB::table('currencies')->where('symbol', $symbol)->first();
    if ($currency) {
        DB::table('currencies')->where('symbol', '!=', $symbol)->update(['default' => 0]);
        DB::table('currencies')->where('id', $currency->id)->where('symbol', '=', $symbol)->update(['default' => 1]);
        Session::put('changed_currency', $symbol);
        Session::put('changed_currency_code', $currency->code);
    }
    return back();
}
//---------------------------------- currencySwitch Code End-------------------------------

// ---------------------update_currency code start----------------------
    public function update_currency(Request $request)
    {
        Artisan::call('currency:update -o');
        return response()->json(['success' => 'Currency Rate Auto Update Successfully ! !']);
    }
// ---------------------update_currency code end----------------------

}
