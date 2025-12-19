<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\str;
use Illuminate\Support\Facades\DB;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class ForgetPasswordController extends Controller
{
    public function forgetPasswordPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(), // You can use the now() helper function
        ]);

        // Send an email if you still want to send an email response
        Mail::to($request->email)->send(new ResetPasswordMail($token));

        return response()->json(['message' => 'A reset token has been sent to your email address.'], 200);
    }

    public function resetPassword(Request $request)
    {
        if ($request->password !== $request->password_confirmation) {
            return response()->json(['error' => 'Password and confirmation do not match.'], 402);
        }
        $token = $request->token;
        $passwordReset = DB::table('password_reset_tokens')->where('token', $token)->first();
        if (!$passwordReset) {
            return response()->json(['error' => 'Invalid token.'], 402);
        }
        $email = $passwordReset->email;
        DB::table('password_reset_tokens')->where('email', $email)->update(['token' => $token]);
        DB::table('users')->where("email", $email)->update(["password" => Hash::make($request->password)]);
        return response()->json(['message' => 'Password reset successful. You can now log in with your new password.'], 200);
    }

}
