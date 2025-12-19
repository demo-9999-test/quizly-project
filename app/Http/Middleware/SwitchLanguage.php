<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Models\LanguageSetting;

class SwitchLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
{
    $defaultLanguage = LanguageSetting::where('status', '=', 1)->first();

    if (!Session::has('changed_language')) {
        $changedLanguage = isset($defaultLanguage) ? $defaultLanguage->local : 'en';
        Session::put('changed_language', $changedLanguage);
    }

    App::setLocale(Session::get('changed_language'));

    return $next($request);
}
}
