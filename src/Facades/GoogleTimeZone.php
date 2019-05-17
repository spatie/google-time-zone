<?php

namespace Spatie\GoogleTimeZone\Facades;

use Illuminate\Support\Facades\Facade;

class GoogleTimeZone extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'google-time-zone';
    }
}
