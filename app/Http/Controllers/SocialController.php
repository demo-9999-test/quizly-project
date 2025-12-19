<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use App\Models\SocialSetting;

class SocialController extends Controller
{

    public function update(Request $request)
    {
        $envFile = app()->environmentFilePath();
        $envContents = file_get_contents($envFile);

        $socialPlatforms = [
            'GOOGLE', 'FACEBOOK', 'GITLAB', 'LINKEDIN', 'GITHUB', 'AMAZON'
        ];

        foreach ($socialPlatforms as $platform) {
            $clientId = $request->input("{$platform}_CLIENT_ID");
            $clientSecret = $request->input("{$platform}_CLIENT_SECRET");
            $callbackUrl = $request->input("{$platform}_CALLBACK_URL") ?? $request->input("{$platform}_REDIRECT_URI");

            $envContents = preg_replace(
                "/{$platform}_CLIENT_ID=.*/",
                "{$platform}_CLIENT_ID=" . $clientId,
                $envContents
            );

            $envContents = preg_replace(
                "/{$platform}_CLIENT_SECRET=.*/",
                "{$platform}_CLIENT_SECRET=" . $clientSecret,
                $envContents
            );

            $envContents = preg_replace(
                "/{$platform}_CALLBACK_URL=.*/",
                "{$platform}_CALLBACK_URL=" . $callbackUrl,
                $envContents
            );
        }

        file_put_contents($envFile, $envContents);

        // Update toggle statuses in the database
        $socialSettings = SocialSetting::first();

        $socialSettings->facebook_status = $request->input('facebook_status') ? 1 : 0;
        $socialSettings->google_status = $request->input('google_status') ? 1 : 0;
        $socialSettings->gitlab_status = $request->input('gitlab_status') ? 1 : 0;
        $socialSettings->amazon_status = $request->input('amazon_status') ? 1 : 0;
        $socialSettings->linkedin_status = $request->input('linkedin_status') ? 1 : 0;

        $socialSettings->save();

        return redirect()->back()->with('success', 'Social Login Settings updated successfully.');
    }
}
