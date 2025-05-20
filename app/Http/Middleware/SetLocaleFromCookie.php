<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class SetLocaleFromCookie
{
    public function handle($request, Closure $next)
    {

        $locale = $request->cookie('locale', config('app.locale'));
        

        if (in_array($locale, ['en', 'sk'])) {
            App::setLocale($locale);
            Log::info('App locale set to', ['locale' => App::getLocale()]);
        }


        return $next($request);
    }
}
