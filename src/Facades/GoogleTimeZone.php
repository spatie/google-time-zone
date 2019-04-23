<?php

namespace Spatie\GoogleTimeZone\Facades;

use Illuminate\Support\Facades\Facade;

final class GoogleTimeZone extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'google-time-zone';
    }
}
