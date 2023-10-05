<?php

namespace UgurAkcil\VoyagerBooster\Http\Middleware;

use Carbon\Carbon;
use Closure;

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
        $locale = $this->detectLocale();

        app()->setLocale($locale);
        Carbon::setLocale($locale);
        setlocale(LC_TIME, $locale.'_'.mb_strtoupper($locale).'.utf8');

        return $next($request);
    }

    protected function detectLocale()
    {
        $available_locales = \Config::get('app.available_locales');

        // Check multidomain locale
        if (\Config::get('app.multidomain')) {
            $serverName = request()->server('SERVER_NAME');
            foreach ($available_locales as $localeKey => $localeVal) {
                if (str_contains($serverName, $localeVal)) {
                    return $localeKey;
                }
            }
        }

        // Check segment-based locale
        $segmentLocaleKey = request()->segment(1);
        if (array_key_exists($segmentLocaleKey, $available_locales)) {

            \URL::defaults(['lang' => $segmentLocaleKey]);

            return $segmentLocaleKey;
        }

        $defaultLocaleKey = array_key_first($available_locales);

        // Return default locale
        return $defaultLocaleKey;
    }
}
