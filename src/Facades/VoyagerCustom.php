<?php
namespace UgurAkcil\VoyagerBooster\Facades;

use Illuminate\Support\Facades\Facade;

class VoyagerCustom extends Facade{
    protected static function getFacadeAccessor()
    {
        return 'VoyagerCustom';
    }
}
