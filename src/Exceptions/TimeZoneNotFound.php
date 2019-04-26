<?php

namespace Spatie\GoogleTimeZone\Exceptions;

use Exception;

final class TimeZoneNotFound extends Exception
{
    public static function forCoordinates(string $latitude, string $longitude): TimeZoneNotFound
    {
        return new self("No time zone was found for coordinates (`{$latitude}`, `{$longitude}`)");
    }
}
