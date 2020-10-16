<?php
if (! function_exists('localizedDate')) {
    /**
     * Format number
     *
     * @param $value
     * @param $attribute
     * @param $data
     * @return boolean
     */
    function localizedDate($date, $format)
    {
        $newDate = new Carbon\Carbon;
        echo $newDate::parse($date)->formatLocalized($format);
    }

}

if (! function_exists('helperCheck')) {
    function helperCheck() {
        return 'Helpers working';
    }
}
