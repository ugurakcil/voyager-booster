<?php
if (!function_exists('localizedDate')) {
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

if (!function_exists('helperCheck')) {
    function helperCheck()
    {
        return 'Helpers working';
    }
}

if (!function_exists('hasCategoryInArray')) {
    function hasCategoryInArray($records, $categoryField, $exceptedValue)
    {
        foreach ($records as $record) {
            if ($record[$categoryField] == $exceptedValue) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('afterImageName')) {
    function afterImageName($filename, $append)
    {
        return preg_replace('/(.*?)\.(jpg|png|gif|JPG|PNG|GIF|jpeg|JPEG)/', '$1-' . $append . '.$2', $filename);
    }
}

if (!function_exists('strupper')) {
    function strupper($text)
    {
        if (app()->getLocale() == 'tr')
            return Transliterator::create('tr-Upper')->transliterate($text);

        return mb_convert_case($text, MB_CASE_UPPER, "UTF-8");
    }
}

if (!function_exists('strlower')) {
    function strlower($text)
    {
        if (app()->getLocale() == 'tr')
            return Transliterator::create('tr-Lower')->transliterate($text);

        return mb_convert_case($text, MB_CASE_LOWER, "UTF-8");
    }
}

if (!function_exists('strtitle')) {
    function strtitle($text)
    {
        if (app()->getLocale() == 'tr')
            return Transliterator::create('tr-Title')->transliterate($text);

        return mb_convert_case($text, MB_CASE_TITLE, "UTF-8");
    }
}

if (!function_exists('numberLocalization')) {
    function numberLocalization($numbers, $from, $to)
    {
        $numberSeries = [
            'en' => ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
            'ar' => ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'],
            'ir' => ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'],
            'in' => ['०', '१', '२', '३', '४', '५', '६', '७', '८', '९']
        ];

        if (!isset($numberSeries[$from])) {
            $from = 'en';
        }

        if (!isset($numberSeries[$to])) {
            return $numbers;
        }

        return str_replace($numberSeries[$from], $numberSeries[$to], $numbers);
    }
}

if (!function_exists('phoneNumberFormat')) {
    function phoneNumberFormat($phoneNumber, $lang = 'en')
    {
        if($lang == 'ar') {
            // The direction of the text is distorted as it goes from number to text. Don't format it!
            // $formattedPhoneNumber = preg_replace('~(.*)([\p{Arabic}]{3})[^\p{Arabic}]{0,7}([\p{Arabic}]{3})[^\p{Arabic}]{0,7}([\p{Arabic}]{4}).*~', '$1$2$3$4', $phoneNumber);

            return $phoneNumber . "\n";
        } else {
            return preg_replace('~(.*)(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1 ($2) $3-$4', $phoneNumber) . "\n";
        }
    }
}

if (!function_exists('localizatedPhoneNumberFormat')) {
    function localizatedPhoneNumberFormat($phoneNumber, $from, $to)
    {
        $localizatedPhoneNumber = numberLocalization($phoneNumber, $from, $to);
        return phoneNumberFormat($localizatedPhoneNumber, $to);
    }
}

