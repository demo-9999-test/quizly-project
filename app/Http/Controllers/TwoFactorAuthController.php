<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PragmaRX\Google2FA\Google2FA;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Hash;



class TwoFactorAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:2fa.manage', ['only' => ['enable2fa','show2faForm','generate2faSecret','disable2fa','verify']]);
    }
    public function show2faForm()
    {
    	$user = Auth::user();
        $google2fa_url = "";
        $google2fa = app('pragmarx.google2fa');

        if($user->google2fa_secret == ''){
            $user->google2fa_secret = $google2fa->generateSecretKey();
            $user->save();
        }
        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $user->google2fa_secret
        );
        return view('admin.project-settings.2fa',compact('QR_Image'));
    }

    public function generate2faSecret(Request $request){
    	$user = Auth::user();
        $google2fa = app('pragmarx.google2fa');
        $user->google2fa_secret = $google2fa->generateSecretKey();
        $user->save();
        return back();
    }

    public function enable2fa(Request $request)
    {
        if (config('app.demolock') == 1) {
            return back()->with('error', 'Disabled in demo');
        }

        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');
        $secret = $request->input('one_time_password');
        $valid = $google2fa->verifyKey($user->google2fa_secret, $secret);
        if($valid){
            $user->is_2fa_enabled = 1;
            $user->save();
            return back()->with('success',"2FA is enabled successfully.");
        }else{
            return back()->with('delete',"Invalid verification Code, Please try again.");
        }
    }

    public function disable2fa(Request $request){
        if (!(\Illuminate\Support\Facades\Hash::check($request->get('password'), Auth::user()->password))) {
            Session::flash('success','Your password does not matches with your account password. Please try again');
            return back();
        }
        $validatedData = $request->validate([
            'password' => 'required',
        ]);
        $user = Auth::user();
        $user->is_2fa_enabled = 0;
        $user->google2fa_secret = NULL;
        $user->save();
        return redirect('/two-factor/auth')->with('error',"2FA is now disabled.");
    }

    public function verify(Request $request){
        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');
        $secret = $request->input('password');
        $valid = $google2fa->verifyKey($user->google2fa_secret, $secret);
        if($valid){
            Cookie::queue('two_fa',1);
            return redirect()->intended('/');
        }else{
            return back()->withErrors(['password' => 'Invalid pin !']);
        }
    }
}
