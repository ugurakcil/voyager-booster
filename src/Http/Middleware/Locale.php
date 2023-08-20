<?php

namespace UgurAkcil\VoyagerBooster\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Session;

class Locale
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

        /*
        * If the first segment is not a language code
        * then set the default locale.
        */
        if(array_key_exists(request()->segment(1), \Config::get('app.available_locales'))) {
            $locale = request()->segment(1);
        } else {
            $locale = array_key_first(\Config::get('app.available_locales'));
        }

        app()->setLocale($locale);
        Carbon::setLocale($locale);

        setlocale(LC_TIME, $locale.'_'.mb_strtoupper(app()->getLocale()).'.utf8');

        \URL::defaults(['lang' => $locale]);

        return $next($request);
    }
}
