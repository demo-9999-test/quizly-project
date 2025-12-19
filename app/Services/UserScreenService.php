<?php

namespace App\Services;

use App\Models\UserScreen;
use App\Models\User;
use App\Models\Packages;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserScreenService
{
    public function trackUserLogin(User $user)
    {
        // Get user's package
        $package = $user->currentPackage;

        // Check if package has screen limit
        if (!$package || $package->screen_number <= 0) {
            return null;
        }

        // Get current IP and MAC
        $ipAddress = request()->ip();
        $macAddress = $this->getMacAddress();

        // Check for existing active screens
        $activeScreens = UserScreen::where('user_id', $user->id)
            ->where('package_id', $package->id)
            ->where('login_status', 'active')
            ->get();

        // If screens exceed package limit, logout the first screen
        if ($activeScreens->count() >= $package->screen_number) {
            $oldestScreen = $activeScreens->first();
            $this->logoutExistingScreen($oldestScreen);
        }

        // Create new user screen entry
        return UserScreen::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'ip_address' => $ipAddress,
            'mac_address' => $macAddress,
            'user_agent' => request()->userAgent(),
            'login_time' => now(),
            'session_id' => Str::uuid(),
            'login_status' => 'active'
        ]);
    }

    private function logoutExistingScreen(UserScreen $screen)
    {
        // Update existing screen
        $screen->update([
            'logout_time' => now(),
            'login_status' => 'logged_out',
            'is_active' => false
        ]);

        // Send logout notification email
        // $this->sendLogoutNotificationEmail($screen->user, $screen);
    }

    private function sendLogoutNotificationEmail($user, $screen)
    {
        Mail::send('emails.screen_logout', [
            'user' => $user,
            'screen' => $screen
        ], function($message) use ($user) {
            $message->to($user->email)->subject('Device Logout Notification');
        });
    }

    private function getMacAddress()
    {
        // This is platform-specific and might require system-level commands
        // For web, you might need to use browser fingerprinting techniques
        // Example (not foolproof):
        return hash('sha256', request()->ip() . request()->userAgent());
    }

    public function logoutUserScreen($userId, $sessionId)
    {
        $screen = UserScreen::where('user_id', $userId)
            ->where('session_id', $sessionId)
            ->where('login_status', 'active')
            ->first();

        if ($screen) {
            $screen->update([
                'logout_time' => now(),
                'login_status' => 'logged_out',
                'is_active' => false
            ]);
        }
    }
}
