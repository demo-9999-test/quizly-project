<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; // ✅ Add this
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Step 1: Basic validation
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required'
             ], [
            'g-recaptcha-response.required' => 'Please complete the captcha to continue.'
        ]);

        // Step 2: reCAPTCHA verification
        $recaptcha = $request->input('g-recaptcha-response');
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!$response->ok() || !$response->json('success')) {
            return response()->json(['error' => 'Captcha validation failed'], 422);
        }

        // Step 3: Auth attempt
        $user_data = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

        $remember_me = $request->has('remember_me') ? true : false;

        if (Auth::attempt($user_data, $remember_me)) {
            $user = Auth::user();
            if ($user->role == 'Admin' || $user->role == 'admin') {
                $token = $user->createToken('MyAppToken', ['admin'])->plainTextToken;
            } else {
                $token = $user->createToken('MyAppToken')->plainTextToken;
            }

            return response()->json([
                'token_type' => 'Bearer',
                'access_token' => encrypt($token),
                'message' => 'Welcome to the Admin Dashboard'
            ], 200);
        } else {
            return response()->json(['error' => 'Incorrect Login Details'], 401);
        }
    }
}
