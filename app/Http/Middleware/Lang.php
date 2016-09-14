<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class Lang
{
    public function handle($request, Closure $next)
    {
        if (Session::has('applocale') AND in_array(Session::get('applocale'), Config::get('app.available_languages'))) {
            App::setLocale(Session::get('applocale'));
        } else { // This is optional as Laravel will automatically set the fallback language if there is none specified
            App::setLocale(Config::get('app.fallback_locale'));
        }

        view()->share('available_languages', config('app.available_languages', array()));
        view()->share('current_language', App::getLocale());
        
        return $next($request);
    }
}