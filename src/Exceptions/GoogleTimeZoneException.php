<?php

namespace Spatie\GoogleTimeZone\Exceptions;

use Exception;

class GoogleTimeZoneException extends Exception
{
    public static function couldNotConnect(): self
    {
        return new static('Could not connect to https://googleapis.com/maps/api');
    }

    public static function serviceReturnedError(string $message): self
    {
        return new static("Google timezone failed because `{$message}`");
    }

    public static function unsupportedLanguage(): self
    {
        return new static("Unsupported google timezone language");
    }
}
