<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ApiSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laracasts\Flash\Flash;
use Laravel\Socialite\Facades\Socialite;
use App\Mail\WelcomeUser;
use App\Mail\ResetPasswordMail;
use App\Models\Affiliate;
use App\Models\AffiliateHistory;
use App\Models\User;
use App\Models\Setting;
use PragmaRX\Google2FAQRCode\Google2FA;
use Twilio\Rest\Client;
use App\Models\SmsSetting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Anhskohbo\NoCaptcha\Facades\NoCaptcha;

class AuthController extends Controller
{
    //------------------------ Register Code Start -------------------------------------------

    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $sett = Setting::first();

        $validationRules = [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'slug' => 'required|unique:users|regex:/^[a-zA-Z0-9_\-\.]+$/|min:3|max:30',
            'password' => 'required|string|min:6|confirmed',
        ];

        // Add mobile validation only if mobile_status is 1
        if ($sett->mobile_status == 1) {
            $validationRules['full_mobile'] = 'required|string|unique:users,mobile';
        }

        $request->validate($validationRules);

        $sms_setting = SmsSetting::first();

        if ($sett->mobile_status == 1 && $sms_setting->twillio_enable == 1) {
            // Generate OTP
            $otp = mt_rand(100000, 999999);

            // Store OTP in session
            session(['registration_otp' => $otp]);
            session(['registration_data' => $request->all()]);

            // Send OTP via Twilio
            $this->sendOTP($request->full_mobile, $otp);

            // Redirect to OTP verification page
            return redirect()->route('verify.otp');
        } else {
            // Proceed with normal registration
            return $this->completeRegistration($request);
        }
    }

    private function sendOTP($phoneNumber, $otp)
    {
        // Fetch Twilio credentials from environment
        $twilioSid = env('TWILIO_SID');
        $authToken = env('TWILIO_AUTH_TOKEN');
        $twilioNumber = env('TWILIO_NUMBER');

        try {
            // Initialize Twilio client
            $client = new Client($twilioSid, $authToken);

            // Send OTP via Twilio
            $message = $client->messages->create(
                $phoneNumber,
                [
                    'from' => $twilioNumber,
                    'body' => "Your OTP is: $otp"
                ]
            );

            // Log success or handle as needed
            Log::info('OTP sent successfully to ' . $phoneNumber);
            Log::info('Twilio Message SID: ' . $message->sid);
        } catch (\Exception $e) {
            Log::error('Twilio Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to send OTP. Please try again.' . $e->getMessage());
        }
    }


    private function completeRegistration($request)
    {
        $sett = Setting::first();
        $af_system = Affiliate::first();
        $refercode = null;
        $referred_by = null;

        if (isset($af_system) && $af_system->status == '1') {
            $refercode = User::createReferCode();
            $findreferal = User::where('affiliate_id', $request['refer_code'])->first();
            if (!$findreferal) {
                Flash::error('Refer code is invalid!')->important();
                return back()->withInput();
            }
        }

        $user = new User;
        $user->name = $request->input('name');
        $user->slug = $request->input('slug');
        $user->email = $request->input('email');
        $user->mobile = $sett->mobile_status == 1 ? $request->input('full_mobile') : null;
        $user->password = bcrypt($request->input('password'));
        $user->affiliate_id = $refercode;
        $user->user_id = $findreferal->id ?? null;
        $user->assignRole('User');
        $user->role = 'U';

        $user->save();

        if (isset($af_system) && $af_system->status == '1') {
            $refer_user_id = $user->id;
            $lastupdateid = User::find($refer_user_id);
            $lastupdateid->refer_user_id = $refer_user_id;
            $lastupdateid->save();

            $data = User::where('id', $findreferal->id)->first();
            $referred_bydata = User::find($refer_user_id);
            $referred_bydata->referred_by = $data->user_id;
            $referred_bydata->save();

            AffiliateHistory::create([
                'log' => 'Refer successful',
                'refer_user_id' => $user->id,
                'user_id' => $findreferal->id,
                'amount' => $af_system->point_per_referral,
                'procces' => 1,
            ]);
        }

        if ($sett->welcome_status == 1) {
            Mail::to($request->email)->send(new WelcomeUser($user));
        }

        Auth::login($user);
        Flash::success('Welcome to the Quizly...')->important();

        return redirect()->route('home.page');
    }

    //------------------------ Register Code End -------------------------------------------


    //------------------------ Login Code Start -------------------------------------------

    public function login()
    {
        return view('auth.login');
    }

    public function login_check(Request $request)
{
    \Log::info('reCAPTCHA Response: ' . $request->input('g-recaptcha-response')); // Debug

    $sett = \App\Models\ApiSetting::first();

    $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    if ($sett && $sett->recaptcha_status == 1) {
        $rules['g-recaptcha-response'] = 'required|captcha';
    }

    try {
        $this->validate($request, $rules);
    } catch (\Illuminate\Validation\ValidationException $e) {
        \Log::error('Validation Error: ' . json_encode($e->errors()));
        throw $e;
    }

    $user_data = $request->only('email', 'password');
    $remember_me = $request->has('remember_me');

    $user = User::where('email', $request->email)->first();
    if (!$user) {
        Flash::error('User not found')->important(); // changed Asc::error -> Flash::error
        return back();
    }

    if (Auth::attempt($user_data, $remember_me)) {
        if (Auth::user()->role == 'A') {
            Flash::success('Welcome to the Admin Dashboard.');
            return redirect('/admin/dashboard');
        } else {
            Flash::success('Welcome to the User Dashboard.');
            return redirect('/');
        }
    } else {
        Flash::error('Incorrect Login Details')->important();
        return back();
    }
}


    //------------------------ Login Code End -------------------------------------------


    //------------------------ Logout  Code Start -------------------------------------------

    public function logout(Request $request)
    {
        Auth::logout();
        Flash::success('You have been logged out successfully.')->important();
        return redirect()->route('login');
    }

    //------------------------ Logout  Code End -------------------------------------------


    //------------------------ redirectToGoogle  Code Start -------------------------------------------
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Unable to authenticate with ' . $provider);
        }

        $providerField = "{$provider}_id";
        $finduser = User::where($providerField, $user->id)->orWhere('email', $user->email)->first();

        if ($finduser) {
            if (!$finduser->$providerField) {
                $finduser->$providerField = $user->id;
                $finduser->save();
            }
            Auth::login($finduser);
            return redirect('/user/dashboard')->with('success', 'Welcome back to the User Dashboard.');
        } else {
            $setting = Setting::first();
            $verified = $setting->verify_enable == 0 ? Carbon::now()->toDateTimeString() : null;
            $password = Str::random(16);

            $newUser = User::create([
                'role' => 'U',
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $verified,
                'password' => Hash::make($password),
                $providerField => $user->id,
            ]);

            if (!$newUser) {
                return redirect()->back()->with('error', 'Unable to create user account.');
            }
            $newUser->assignRole('User');

            Auth::login($newUser);
            return redirect('/user/dashboard')->with('success', 'Welcome to the User Dashboard.');
        }
    }

    //------------------------ redirectToFacebook  Code End -------------------------------------------


    //------------------------ Forget Password Code Start -------------------------------------------

    public function forgetPassword()
    {
        return view('auth.forgetpassword');
    }

    public function forgetPasswordPost(Request $request)
    {
        try{
            $request->validate([
                'email' => 'required|email|exists:users',
            ]);

            $token = Str::random(64);
            $existingToken = DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->first();

            if ($existingToken) {
                DB::table('password_reset_tokens')
                    ->where('email', $request->email)
                    ->update([
                        'token' => $token,
                        'created_at' => now(),
                    ]);
            } else {
                DB::table('password_reset_tokens')->insert([
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => now(),
                ]);
            }

            Mail::to($request->email)->send(new ResetPasswordMail(['token' => $token]));
            return redirect()->route("forget.password")->with('success','A fresh verification link has been sent to your email address.');
        }catch (\Exception $e) {
            $errorMessage = 'An error occurred: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }

    //------------------------ Forget Password Code End -------------------------------------------


    //------------------------ Reset Password Code Start -------------------------------------------

    public function resetPassword($token)
    {
        return view('admin.emails.newpassword', compact('token'));
    }

    public function resetPasswordPost(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $token = $request->token;
        $passwordReset = DB::table('password_reset_tokens')->where('token', $token)->first();

        if (!$passwordReset) {
            Flash::error('Invalid token.')->important();
            return redirect()->route("reset.password");
        }

        $email = $passwordReset->email;
        $user = User::where("email", $email)->first();

        if (!$user) {
            Flash::error('User does not exist.')->important();
            return redirect()->route("reset.password");
        } else {
            $user->update(['password' => Hash::make($request->password)]);
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            Flash::success("Password reset successful. You can now login with your new password.")->important();
            return redirect()->route("login");
        }
    }

    //------------------------ Reset Password Code End -------------------------------------------
    public function generate2faSecretAndLogin(Request $request)
    {
        $google2fa = new Google2FA();
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();
        if ($user && Hash::check($credentials['password'], $user->password)) {
            $secret = $google2fa->generateSecretKey();
            $qrCodeUrl = $google2fa->getQRCodeUrl(
                config('app.name'),
                $user->email,
                $secret
            );
            $user->update(['google2fa_secret' => $secret]);
            Auth::login($user);
            return redirect()->route('admin.dashboard')->with(compact('qrCodeUrl'));
        }
        return redirect()->route('login')->with('error', 'Invalid email or password');
    }

    public function handleGoogleCallback()
{
    $googleUser = Socialite::driver('google')->stateless()->user();

    $user = User::updateOrCreate([
        'email' => $googleUser->getEmail(),
    ], [
        'name' => $googleUser->getName(),
        'google_id' => $googleUser->getId(),
        'avatar' => $googleUser->getAvatar(),
    ]);

    Auth::login($user);

    // ✅ Redirect user where you want (e.g., dashboard)
    return redirect('/dashboard');
}
}
