<?php

return [

    /*
     * The api key used when sending timezone requests to Google.
     */
    'key' => env('GOOGLE_MAPS_TIMEZONE_API_KEY', ''),

    /*
     * The language param used to set response translations for textual data.
     *
     * More info: https://developers.google.com/maps/faq#languagesupport
     */
    'language' => '',
];
