<?php

namespace Spatie\GoogleTimeZone\Exceptions;

use Exception;

final class GoogleTimeZoneException extends Exception
{
    public static function couldNotConnect()
    {
        return new static('Could not connect to googleapis.com/maps/api');
    }

    public static function serviceReturnedError(string $message)
    {
        return new static("Google timezone failed because `{$message}`");
    }
}
