<?php

namespace Spatie\GoogleTimeZone;

class GoogleTimeZoneResponse
{
    /** @var string */
    public $status;

    /** @var string */
    public $errorMessage;

    /** @var string */
    public $dstOffset;

    /** @var string */
    public $rawOffset;

    /** @var string */
    public $timeZoneId;

    /** @var string */
    public $timeZoneName;
}
