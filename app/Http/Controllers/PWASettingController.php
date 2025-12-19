<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Illuminate\Support\Facades\Artisan;
use Image;
use Laracasts\Flash\Flash;

class PWASettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pwa.manage', ['only' => ['index','store','show']]);
    }

    //---------------------------------- Page View Code start-------------------------------
    public function index() {
        return view('admin.project-settings.pwa-setting');
    }
    //---------------------------------- Page View Code end-------------------------------

    //---------------------------------- Data Store Code start-------------------------------
    public function store(Request $request)
    {
        if (config('app.demolock') == 1) {
            return back()->with('error','Demo mode is enabled. Data cannot be updated');
        }
        $request->validate([
            'icon_512' => 'mimes:png|max:2000',
            'splash_2048' => 'mimes:png|max:2000',
        ]);
        $imagePath = public_path('/images/icons');
        if ($request->file('icon_512')) {
            ini_set('max_execution_time', -1);
            $image = $request->file('icon_512');
            $img = Image::make($image->path());
            // 512 x 512
            $icon512 = 'icon-512x512.' . $image->getClientOriginalExtension();
            $img->resize(512, 512);
            $img->save($imagePath . '/' . $icon512, 90);
            // 384x384
            $icon256 = 'icon-384x384.' . $image->getClientOriginalExtension();
            $img->resize(384, 384);
            $img->save($imagePath . '/' . $icon256, 90);
            // 192x192
            $icon192 = 'icon-192x192.' . $image->getClientOriginalExtension();
            $img->resize(192, 192);
            $img->save($imagePath . '/' . $icon192, 90);
            // 152x152
            $icon192 = 'icon-152x152.' . $image->getClientOriginalExtension();
            $img->resize(152, 152);
            $img->save($imagePath . '/' . $icon192, 90);
            // 144x144
            $icon144 = 'icon-144x144.' . $image->getClientOriginalExtension();

            $img->resize(144, 144);

            $img->save($imagePath . '/' . $icon144, 90);

            // 128x128

            $icon128 = 'icon-128x128.' . $image->getClientOriginalExtension();

            $img->resize(128, 128);

            $img->save($imagePath . '/' . $icon128, 90);

            // 96x96

            $icon96 = 'icon-96x96.' . $image->getClientOriginalExtension();

            $img->resize(96, 96);

            $img->save($imagePath . '/' . $icon96, 90);

            // 72x72

            $icon72 = 'icon-72x72.' . $image->getClientOriginalExtension();

            $img->resize(72, 72);

            $img->save($imagePath . '/' . $icon72, 90);
        }
        /** Splash Screens */
        if ($file = $request->file('splash_2048')) {

            ini_set('max_execution_time', -1);

            $image = $request->file('splash_2048');

            $img = Image::make($image->path());

            // 2048x2732

            $splash2732 = 'splash-2048x2732.' . $image->getClientOriginalExtension();

            $img->resize(2048, 2732);

            $img->save($imagePath . '/' . $splash2732, 95);

            // 1668x2388

            $splash2388 = 'splash-1668x2388.' . $image->getClientOriginalExtension();

            $img->resize(1668, 2388);

            $img->save($imagePath . '/' . $splash2388, 95);

            // 1668x2224

            $splash2224 = 'splash-1668x2224.' . $image->getClientOriginalExtension();

            $img->resize(1668, 2224);

            $img->save($imagePath . '/' . $splash2224, 95);

            // 1536x2048

            $splash2048 = 'splash-1536x2048.' . $image->getClientOriginalExtension();

            $img->resize(1536, 2048);

            $img->save($imagePath . '/' . $splash2048, 95);

            // 1242x2688

            $splash2688 = 'splash-1242x2688.' . $image->getClientOriginalExtension();

            $img->resize(1242, 2688);

            $img->save($imagePath . '/' . $splash2688, 95);

            // 1242x2208

            $splash2208 = 'splash-1242x2208.' . $image->getClientOriginalExtension();

            $img->resize(1242, 2208);

            $img->save($imagePath . '/' . $splash2208, 95);

            // 1125x2436

            $splash2436 = 'splash-1125x2436.' . $image->getClientOriginalExtension();

            $img->resize(1125, 2436);

            $img->save($imagePath . '/' . $splash2436, 95);

            // 828x1792

            $splash1792 = 'splash-828x1792.' . $image->getClientOriginalExtension();

            $img->resize(828, 1792);

            $img->save($imagePath . '/' . $splash1792, 95);

            // 750x1334

            $splash1334 = 'splash-750x1334.' . $image->getClientOriginalExtension();

            $img->resize(750, 1334);

            $img->save($imagePath . '/' . $splash1334, 95);

            // 640x1136

            $splash1136 = 'splash-640x1136.' . $image->getClientOriginalExtension();

            $img->resize(640, 1136);

            $img->save($imagePath . '/' . $splash1136, 95);

        }
        \Artisan::call('view:cache');
        \Artisan::call('view:clear');
        $env_update = DotenvEditor::setKeys([
            // Update .env file with new values
            'APP_URL' => $request->input('APP_URL'),
            'APP_NAME' => $request->input('APP_NAME'),
            'PWA_BG_COLOR' => $request->input('PWA_BG_COLOR'),
            'PWA_THEME_COLOR' => $request->input('PWA_THEME_COLOR'),
            'PWA_ENABLE' => $request->has('PWA_ENABLE') ? 'true' : 'false',
        ]);
        $env_update->save();
        return redirect('admin/pwa-setting')->with('success','Data has been updated.');
    }
    //---------------------------------- Data Store Code end-------------------------------

    //---------------------------------- All Data Show Code start-------------------------------
    public function show(Request $request)
    {
        $appurl= env('APP_URL');
        $appname = env('APP_NAME');
        $pwabgcolor = env('PWA_BG_COLOR');
        $pwathemecolor = env('PWA_THEME_COLOR');
        $pwaenable = env('PWA_ENABLE');
        return view('admin.project-settings.pwa-setting', compact(
            'pwabgcolor',
            'pwathemecolor',
            'pwaenable',
            'appname',
            'appurl',
        ));
    }
    //---------------------------------- All Data Show Code end-------------------------------
}
