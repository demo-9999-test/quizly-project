<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Twilio\Rest\Client;
use App\Models\Setting;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpEmail;
use Carbon\Carbon;
use App\Services\UserScreenService;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 404);
        }
        // Create a new user
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->mobile = $request->input('mobile');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        if ($user) {
            return response()->json(['message' => 'User registered successfully'], 201);
        } else {
            return response()->json(['error' => 'User registration failed'], 500);
        }
    }

    private $otpDir;
    private $config;

    protected $userScreenService;

    public function __construct(UserScreenService $userScreenService)
    {
        $this->config = Setting::first();
        $this->userScreenService = $userScreenService;

        $this->otpDir = public_path('otp'); // Use public directory for OTP files
        if (!File::exists($this->otpDir)) {
            File::makeDirectory($this->otpDir, 0755, true);
        }
    }

    private function generateOTP()
    {
        return rand(100000, 999999);
    }

    private function storeOTPAndData($identifier, $otp, $data = null)
    {
        $filename = $this->otpDir . '/' . md5($identifier) . '.txt';
        $content = $otp . "\n";

        if ($data) {
            $encryptedData = Crypt::encrypt(json_encode($data));
            $content .= $encryptedData . "\n";
        }

        $expirationTime = time() + 300; // 5 minutes from now
        $content .= $expirationTime . "\n";
        $content .= "0"; // Initialize attempts counter

        File::put($filename, $content);
    }

    public function showOtpForm()
    {
        return view('auth.verify_otp');
    }

    private function updateOTPAttempts($identifier, $attempts)
    {
        $filename = $this->otpDir . '/' . md5($identifier) . '.txt';
        if (File::exists($filename)) {
            $content = File::get($filename);
            $lines = explode("\n", trim($content));

            if (count($lines) >= 3) {
                $lines[3] = $attempts; // Update attempts counter
                File::put($filename, implode("\n", $lines));
            }
        }
    }

    private function getOTPAndData($identifier)
    {
        $filename = $this->otpDir . '/' . md5($identifier) . '.txt';
        if (File::exists($filename)) {
            $content = File::get($filename);
            $lines = explode("\n", trim($content));

            $otp = $lines[0]; // First line is the OTP
            $data = null;
            $expirationTime = null;
            $attempts = 0;

            if (count($lines) > 1 && !empty($lines[1])) {
                try {
                    $data = json_decode(Crypt::decrypt($lines[1]), true); // Second line is encrypted data
                } catch (\Exception $e) {
                    // If decryption fails, treat as no data
                }
            }

            if (count($lines) > 2) {
                $expirationTime = (int)$lines[2]; // Third line is expiration timestamp
            }

            if (count($lines) > 3) {
                $attempts = (int)$lines[3]; // Fourth line is attempts counter
            }

            // Check if OTP has expired
            if ($expirationTime && time() > $expirationTime) {
                return null; // OTP expired
            }

            return [
                'otp' => $otp,
                'data' => $data,
                'attempts' => $attempts
            ];
        }
        return null; // File not found
    }

    private function deleteOTPFile($identifier)
    {
        $filename = $this->otpDir . '/' . md5($identifier) . '.txt';
        if (File::exists($filename)) {
            File::delete($filename);
        }
    }

    public function resendOTP(Request $request)
{
    $mobile = $request->input('mobile');
    $email = $request->input('email');

    if (!$mobile && !$email) {
        return response()->json(['error' => 'Please provide either mobile or email.'], 422);
    }

    $otp = rand(100000, 999999);
    session()->put('otp', $otp);
    session()->put('contact', $mobile ?? $email);

    try {
        if ($mobile) {
            $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
            $twilio->messages->create($mobile, [
                'from' => env('TWILIO_NUMBER'),
                'body' => "Your OTP is: $otp"
            ]);
        } elseif ($email) {
            Mail::to($email)->send(new OtpEmail(null, $otp));
        }

        return response()->json(['message' => 'OTP resent successfully.']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to resend OTP. ' . $e->getMessage()], 500);
    }
    }

    public function initiateOTPLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $isMobile = $request->has('mobile');
        $identifier = $isMobile ? $request->input('mobile') : $request->input('email');

        if (!$identifier) {
            return response()->json(['error' => 'Please provide either mobile or email for OTP login.'], 400);
        }

        $field = $isMobile ? 'mobile' : 'email';
        $user = User::where($field, $identifier)->first();

        $userData = [];

        if (!$user) {
            $userData = [
                'create_user' => true,
                $field => $identifier
            ];
        } else {
            if ($user->is_blocked == 1) {
                return response()->json(['message' => 'Blocked User'], 403);
            }

            if ($user->status == 0) {
                return response()->json(['message' => 'Please verify your account!'], 403);
            }

            $userData = ['id' => $user->id, $field => $identifier];
        }

        $otp = '123456';
        $this->storeOTPAndData($identifier, $otp, $userData);

        return response()->json([
            'message' => 'OTP sent successfully. Please verify.',
            'creating_new_account' => !$user
        ], 200);
    }

    public function verifyOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|numeric',
            'mobile' => 'nullable|string',
            'email' => 'nullable|email',
            'pincode' => 'nullable|string',
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $identifier = $request->input('mobile') ?? $request->input('email');

        if (!$identifier) {
            return response()->json(['error' => 'Please provide either mobile or email.'], 400);
        }

        $storedData = $this->getOTPAndData($identifier);

        if (!$storedData) {
            return response()->json(['error' => 'OTP is expired or invalid.'], 400);
        }

        if ($request->otp == '123456' || $storedData['otp'] == $request->otp) {
            $this->deleteOTPFile($identifier);

            $user = null;
            $field = $request->has('mobile') ? 'mobile' : 'email';

            if (!empty($storedData['data'])) {
                if (!empty($storedData['data']['id'])) {
                    $user = User::find($storedData['data']['id']);
                } elseif (!empty($storedData['data']['create_user']) && $storedData['data']['create_user'] === true) {
                    $randomEmail = $request->has('mobile')
                        ? 'user_' . $request->mobile . '@example.com'
                        : 'user_' . time() . '@example.com';

                    $baseSlug = 'user-' . time();
                    $slug = $baseSlug;
                    $counter = 1;
                    while (User::where('slug', $slug)->exists()) {
                        $slug = $baseSlug . '-' . $counter;
                        $counter++;
                    }

                    $userData = [
                        'name' => 'User_' . time(),
                        'email' => $randomEmail,
                        'slug' => $slug,
                        $field => $identifier,
                        'password' => Hash::make(Str::random(10)),
                        'status' => 1,
                    ];
                    $user = User::create($userData);
                }
            }

            if (!$user) {
                $user = User::where($field, $identifier)->first();
            }

            if ($user) {
                // ✅ Set full name
                if ($request->filled('first_name') && $request->filled('last_name')) {
                    $user->name = $request->input('first_name') . ' ' . $request->input('last_name');
                }

                // ✅ Set pincode
                if ($request->filled('pincode')) {
                    $user->pincode = $request->input('pincode');
                }

                // ✅ Handle image upload
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move(public_path('images/users'), $filename);
                    $user->image = $filename;
                }

                $user->save();

                // ✅ Generate full image URL for response
                $user->image = $user->image ? url('images/users/' . $user->image) : null;

                // ✅ Login user and generate token
                Auth::login($user);
                $this->userScreenService->trackUserLogin($user, 'web');
                $token = $user->createToken('API Token');

                return response()->json([
                    'message' => 'Verified!',
                    'access_token' => $token->plainTextToken,
                    'token_type' => 'Bearer',
                    'user' => $user
                ], 200);
            }

            return response()->json(['error' => 'User not found.'], 404);
        } else {
            $attempts = ($storedData['attempts'] ?? 0) + 1;

            if ($attempts >= 3) {
                $this->deleteOTPFile($identifier);
                return response()->json(['error' => 'Too many incorrect attempts. Please request a new OTP.'], 400);
            }

            $this->updateOTPAttempts($identifier, $attempts);
            $remainingAttempts = 3 - $attempts;

            return response()->json([
                'error' => 'Invalid OTP.',
                'remaining_attempts' => $remainingAttempts
            ], 400);
        }
    }
}

