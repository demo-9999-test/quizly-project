<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Crypt;
use Laracasts\Flash\Flash;
use Spatie\Sitemap\SitemapGenerator;
use App\Models\Setting;
use App\Models\AdminColor;
use App\Models\SocialSetting;
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:login_signup.manage', ['only' => ['login_signup', 'login_signupstore']]);
        $this->middleware('permission:cockpit.manage', ['only' => ['cockpit', 'cockpitstore']]);
        $this->middleware('permission:admin.manage', ['only' => ['admincolor', 'admincolorstore', 'adminreset', 'adminsetting', 'adminsettingstore']]);
        $this->middleware('permission:api.manage', ['only' => ['index']]);
        $this->middleware('permission:sitemap.manage', ['only' => ['sitemap']]);
    }

    //---------------------------------- Page View Code start-------------------------------
    public function index()
    {
        return view('admin.rest-api.index');
    }
    //---------------------------------- Page View Code end-------------------------------

    //----------------------------------login_signup Code start-------------------------------
    public function login_signup()
    {
        $signuplogin = Setting::firstOrNew();

        $socialMediaLogin = SocialSetting::first();

        return view('admin.admin-setting.login_signup', compact(
            'socialMediaLogin',
            'signuplogin'
        ));
    }

    public function login_signupstore(Request $request)
    {
        if (config('app.demolock') == 0) {
            return back()->with('error','This is demo lock');
        }

        // Fetch existing or create new setting (assuming ID = 1)
        $signuplogin = Setting::firstOrNew(['id' => 1]);

        $signuplogin->mobile_status = $request->input('mobile_status') ? 1 : 0;

        // LOGIN IMAGE UPLOAD
        if ($request->hasFile('login_img')) {
            $file = $request->file('login_img');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('images/login_img'), $filename);

            // Remove old login image
            if (!empty($signuplogin->login_img)) {
                $existingImagePath = public_path('images/login_img/' . $signuplogin->login_img);
                if (file_exists($existingImagePath)) {
                    unlink($existingImagePath);
                }
            }

            $signuplogin->login_img = $filename;
        }

        // SIGNUP IMAGE UPLOAD
        if ($request->hasFile('signup_img')) {
            $file = $request->file('signup_img');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('images/signup_img'), $filename);

            // Remove old signup image
            if (!empty($signuplogin->signup_img)) {
                $existingImagePath = public_path('images/signup_img/' . $signuplogin->signup_img);
                if (file_exists($existingImagePath)) {
                    unlink($existingImagePath);
                }
            }

            $signuplogin->signup_img = $filename;
        }

        $signuplogin->save();

        return redirect('admin/cockpit')->with('success', 'Settings updated successfully');
    }

    public function updateGoogleLogin(Request $request)
    {
        $socialSettings = SocialSetting::first();
        $socialSettings->google_status = $request->has('google_status') ? 1 : 0;
        $socialSettings->save();

        $this->updateEnvFile('GOOGLE_CLIENT_ID', $request->input('GOOGLE_CLIENT_ID'));
        $this->updateEnvFile('GOOGLE_CLIENT_SECRET', $request->input('GOOGLE_CLIENT_SECRET'));
        $this->updateEnvFile('GOOGLE_REDIRECT_URI', $request->input('GOOGLE_REDIRECT_URI'));

        return redirect()->back()->with('success', 'Google Login Settings updated successfully.');
    }

    public function updateFacebookLogin(Request $request)
    {
        $socialSettings = SocialSetting::first();
        $socialSettings->facebook_status = $request->has('facebook_status') ? 1 : 0;
        $socialSettings->save();

        $this->updateEnvFile('FACEBOOK_CLIENT_ID', $request->input('FACEBOOK_CLIENT_ID'));
        $this->updateEnvFile('FACEBOOK_CLIENT_SECRET', $request->input('FACEBOOK_CLIENT_SECRET'));
        $this->updateEnvFile('FACEBOOK_REDIRECT', $request->input('FB_CALLBACK_URL'));

        return redirect()->back()->with('success', 'Facebook Login Settings updated successfully.');
    }

    public function updateGitlabLogin(Request $request)
    {
        $socialSettings = SocialSetting::first();
        $socialSettings->gitlab_status = $request->has('gitlab_status') ? 1 : 0;
        $socialSettings->save();

        $this->updateEnvFile('GITLAB_CLIENT_ID', $request->input('GITLAB_CLIENT_ID'));
        $this->updateEnvFile('GITLAB_CLIENT_SECRET', $request->input('GITLAB_CLIENT_SECRET'));
        $this->updateEnvFile('GITLAB_REDIRECT_URI', $request->input('GITLAB_CALLBACK_URL'));

        return redirect()->back()->with('success', 'GitLab Login Settings updated successfully.');
    }

    public function updateLinkedinLogin(Request $request)
    {
        $socialSettings = SocialSetting::first();
        $socialSettings->linkedin_status = $request->has('linkedin_status') ? 1 : 0;
        $socialSettings->save();

        $this->updateEnvFile('LINKEDIN_CLIENT_ID', $request->input('LINKEDIN_CLIENT_ID'));
        $this->updateEnvFile('LINKEDIN_CLIENT_SECRET', $request->input('LINKEDIN_CLIENT_SECRET'));
        $this->updateEnvFile('LINKEDIN_REDIRECT_URI', $request->input('LINKEDIN_CALLBACK_URL'));

        return redirect()->back()->with('success', 'LinkedIn Login Settings updated successfully.');
    }

    public function updateGithubLogin(Request $request)
    {
        $socialSettings = SocialSetting::first();
        $socialSettings->github_status = $request->has('github_status') ? 1 : 0;
        $socialSettings->save();

        $this->updateEnvFile('GITHUB_CLIENT_ID', $request->input('GITHUB_CLIENT_ID'));
        $this->updateEnvFile('GITHUB_CLIENT_SECRET', $request->input('GITHUB_CLIENT_SECRET'));
        $this->updateEnvFile('GITHUB_REDIRECT_URI', $request->input('GITHUB_CALLBACK_URL'));

        return redirect()->back()->with('success', 'GitHub Login Settings updated successfully.');
    }

    public function updateAmazonLogin(Request $request)
    {
        $socialSettings = SocialSetting::first();
        $socialSettings->amazon_status = $request->has('amazon_status') ? 1 : 0;
        $socialSettings->save();

        $this->updateEnvFile('AMAZON_CLIENT_ID', $request->input('AMAZON_CLIENT_ID'));
        $this->updateEnvFile('AMAZON_CLIENT_SECRET', $request->input('AMAZON_CLIENT_SECRET'));
        $this->updateEnvFile('AMAZON_CALLBACK_URL', $request->input('AMAZON_CALLBACK_URL'));

        return redirect()->back()->with('success', 'Amazon Login Settings updated successfully.');
    }

    private function updateEnvFile($key, $value)
    {
        $path = base_path('.env');
        $oldValue = env($key);

        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                "$key=" . $oldValue,
                "$key=" . $value,
                file_get_contents($path)
            ));
        }
    }
    //---------------------------------- login_signup Code end-------------------------------

    //----------------------------------cookpit Code start-------------------------------
    public function cockpit()
    {
        $settings = Setting::first();
        $appDebug = config('app.debug');
        return view('admin.admin-setting.cockpit', compact('settings', 'appDebug'));
    }

    public function cockpitstore(Request $request)
{
    if (config('app.demolock') == 1) {
        return back();
    }

    // Determine debug value from checkbox (true or false string)
    $debugValue = $request->input('APP_DEBUG') ? 'true' : 'false';

    // Update .env key using DotenvEditor
    DotenvEditor::setKeys([
        'APP_DEBUG' => $debugValue,
    ])->save();

    // Immediately apply new debug config for current request
    config(['app.debug' => $debugValue === 'true']);

    // Clear all relevant caches
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');

    // Update settings in database
    $settings = Setting::firstOrNew();
    $settings->right_click_status = $request->input('right_click_status') ? 1 : 0;
    $settings->inspect_status = $request->input('inspect_status') ? 1 : 0;

    if ($request->input('cookie_status') == 1) {
        $settings->cookie_status = 1;
        $settings->message = $request->input('message');
    } else {
        $settings->cookie_status = 0;
        $settings->message = null;
    }

    $settings->activity_status = $request->input('activity_status') ? 1 : 0;
    $settings->welcome_status = $request->input('welcome_status') ? 1 : 0;
    $settings->verify_status = $request->input('verify_status') ? 1 : 0;
    $settings->save();

    return redirect('admin/cockpit')->with('success', 'Setting updated successfully');
}

    //----------------------------------cookpit Code end-------------------------------
    // ------social login code end------

    // ------admin  color code start------
    public function admincolor()
    {
        $color = AdminColor::first();
        return view('admin.admin-theme.admincolor', compact('color'));
    }

    public function admincolorstore(Request $request)
    {
        $color = AdminColor::firstOrNew();
        $color->fill([
            'bg_light_grey' => strip_tags($request->input('bg_light_grey')),
            'bg_white' => strip_tags($request->input('bg_white')),
            'bg_dark_blue' => strip_tags($request->input('bg_dark_blue')),
            'bg_dark_grey' => strip_tags($request->input('bg_dark_grey')),
            'bg_black' => strip_tags($request->input('bg_black')),
            'bg_yellow' => strip_tags($request->input('bg_yellow')),
            'text_black' => strip_tags($request->input('text_black')),
            'text_dark_grey' => strip_tags($request->input('text_dark_grey')),
            'text_light_grey' => strip_tags($request->input('text_light_grey')),
            'text_dark_blue' => strip_tags($request->input('text_dark_blue')),
            'text_white' => strip_tags($request->input('text_white')),
            'text_red' => strip_tags($request->input('text_red')),
            'text_yellow' => strip_tags($request->input('text_yellow')),
            'border_white' => strip_tags($request->input('border_white')),
            'border_black' => strip_tags($request->input('border_black')),
            'border_light_grey' => strip_tags($request->input('border_light_grey')),
            'border_dark_blue' => strip_tags($request->input('border_dark_blue')),
            'border_dark_grey' => strip_tags($request->input('border_dark_grey')),
            'border_grey' => strip_tags($request->input('border_grey')),
            'border_yellow' => strip_tags($request->input('border_yellow')),
        ]);
        $color->save();
        return redirect('admin/admin-color')->with('success','Data ha been updated successfully');
    }

    public function adminreset()
    {
        Artisan::call('db:seed --class=AdminColorsTableSeeder');
        return back()->with('success', 'Reset Successfully');
    }

    // ------admin  color code end------

    public function adminsetting()
    {
        $adsetting = Setting::first();
        return view('admin.admin-theme.adminsetting', compact('adsetting'));
    }

    public function adminsettingstore(Request $request)
    {
        $adsetting = Setting::firstOrNew();
        if ($request->input('logostatus') == 1) {
            if ($request->hasFile('admin_logo')) {
                $logoFile = $request->file('admin_logo');
                $logoFilename = time() . '.' . $logoFile->getClientOriginalExtension();
                $logoFile->move('images/admin_logo', $logoFilename);
                // Check and delete the existing image
                if ($adsetting->admin_logo != null) {
                    $existingImagePath = public_path('images/admin_logo/' . $adsetting->admin_logo);
                    if (file_exists($existingImagePath)) {
                        unlink($existingImagePath);
                    }
                }
                $adsetting->admin_logo = $logoFilename;
            }
            $adsetting->logostatus = $request->input('logostatus');
        } else {
            $adsetting->admin_logo = $request->input('admin_logo');
        }

        $adsetting->save();
        return back()->with('success','Data store successfully');
    }

    public function sitemap()
    {
        return view('admin.api-setting.sitemap');
    }

    public function generateSitemap()
    {
        // Get all registered routes
        $routes = collect(app('router')->getRoutes())->map(function ($route) {
            return $route->uri();
        })->unique();

        // Create a new sitemap instance
        $sitemap = Sitemap::create();

        // Add each route URL to the sitemap
        foreach ($routes as $route) {
            $url = url($route);
            $sitemap->add(
                Url::create($url)
                    ->setLastModificationDate(Carbon::now()) // Set last modification date to now
                    ->setPriority(0.8) // Set priority to 0.8
                    ->setChangeFrequency('daily') // Set change frequency to daily
            );
        }

        // Write the sitemap to the file
        $sitemap->writeToFile(public_path('sitemap.xml'));

        // Flash success message
        return redirect()->back()->with('success', 'Sitemap generated successfully.');
    }

    public function downloadSitemap()
    {
        $path = public_path('sitemap.xml');
        return Response::download($path);
    }
}
