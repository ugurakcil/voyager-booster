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

if(! function_exists('hasCategoryInArray')) {
    function hasCategoryInArray($records, $categoryField, $exceptedValue) {
        foreach($records as $record) {
            if($record[$categoryField] == $exceptedValue) {
                return true;
            }
        }

        return false;
    }
}

if(! function_exists('afterImageName')) {
    function afterImageName($filename, $append){
        return preg_replace('/(.*?)\.(jpg|png|gif|JPG|PNG|GIF|jpeg|JPEG)/', '$1-'.$append.'.$2', $filename);
    }
}

if(! function_exists('strupper')) {
    function strupper($text){
        if(app()->getLocale() == 'tr')
            return Transliterator::create('tr-Upper')->transliterate($text);

        return mb_convert_case($text, MB_CASE_UPPER, "UTF-8");
    }
}

if(! function_exists('strlower')) {
    function strlower($text){
        if(app()->getLocale() == 'tr')
            return Transliterator::create('tr-Lower')->transliterate($text);

        return mb_convert_case($text, MB_CASE_LOWER, "UTF-8");
    }
}

if(! function_exists('strtitle')) {
    function strtitle($text){
        if(app()->getLocale() == 'tr')
            return Transliterator::create('tr-Title')->transliterate($text);

        return mb_convert_case($text, MB_CASE_TITLE, "UTF-8");
    }
}
