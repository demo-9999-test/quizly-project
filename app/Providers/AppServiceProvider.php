<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Models\FooterSetting;
use App\Models\Pages;
use App\Models\GeneralSetting;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::composer('front.layouts.topbar', function ($view) {
            $top = GeneralSetting::first();
            $view->with('top', $top);
        });

        View::composer('front.layouts.footer', function ($view) {
            $footer = FooterSetting::first();
            $about = GeneralSetting::first();
            $pages = Pages::all();

            $view->with([
                'footer' => $footer,
                'about' => $about,
                'pages' => $pages
            ]);
        });

        // Add this one to make $settings available everywhere
        View::composer('*', function ($view) {
            $settings = \App\Models\Setting::first();
            $view->with('settings', $settings);
        });
    }
}