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
        if(Session::has('locale')) {
            app()->setLocale(Session::get('locale'));
            Carbon::setLocale(Session::get('locale'));
        } else {
            Carbon::setLocale(app()->getLocale());
        }

        setlocale(LC_TIME, app()->getLocale().'_'.mb_strtoupper(app()->getLocale()).'.utf8');

        return $next($request);
    }
}
