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
        if(array_key_exists(request()->segment(1), Config::get('app.available_locales'))) {
            session(['locale' => request()->segment(1)]);
        }

        if(Session::has('locale')) {
            app()->setLocale(Session::get('locale'));
            Carbon::setLocale(Session::get('locale'));
        } else {
            Carbon::setLocale(app()->getLocale());
        }

        setlocale(LC_TIME, app()->getLocale().'_'.mb_strtoupper(app()->getLocale()).'.utf8');

        URL::defaults(['lang' => app()->getLocale()]);
        
        return $next($request);
    }
}
