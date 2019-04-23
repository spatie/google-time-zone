# Get time zones for coordinates

[![Latest Version](https://img.shields.io/github/release/spatie/geocoder.svg?style=flat-square)](https://github.com/spatie/geocoder/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/spatie/geocoder/master.svg?style=flat-square)](https://travis-ci.org/spatie/geocoder)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/c0e7c71d-351a-4996-9d74-24abfa074410.svg?style=flat-square)](https://insight.sensiolabs.com/projects/c0e7c71d-351a-4996-9d74-24abfa074410)
[![StyleCI](https://styleci.io/repos/19355432/shield)](https://styleci.io/repos/19355432)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/geocoder.svg?style=flat-square)](https://packagist.org/packages/spatie/geocoder)

This package can convert GPS coordinates to timzones using [Google's Time Zone service](https://developers.google.com/maps/documentation/timezone/intro). Here's a quick example:

```php
GoogleTimeZone::getTimeZoneForCoordinates('39.6034810', '-119.6822510');

// Will return this array
[
   'dstOffset' : 0,
   'rawOffset' : -28800,
   'timeZoneId' : 'America/Los_Angeles',
   'timeZoneName' : 'Pacific Standard Time'
]
```

## Installation

You can install this package through composer.

```bash
composer require spatie/google-time-zone
```
## Laravel installation

Thought the package works fine in non-Laravel projects we included some niceties for our fellow artisans.

In Laravel will autoregister the package itself, you must publish the config file :

```bash
php artisan vendor:publish --provider="Spatie\Geocoder\GeocoderServiceProvider" --tag="config"
```

This is the content of the config file:

```php
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
```

## Usage

Here's how you can get the timezone for coordinates.

```php
$client = new \GuzzleHttp\Client();

$googleTimeZone = new GoogleTimeZone($client);

$googleTimeZone->setApiKey(config('google-time-zone.key'));

$googleTimeZone->getTimeZoneForCoordinates('39.6034810', '-119.6822510');

/*
// Will return this array
[
    'dstOffset' : 0,
    'rawOffset' : -28800,
    'timeZoneId' : 'America/Los_Angeles',
    'timeZoneName' : 'Pacific Standard Time'
]
*/
```


You can get the result back in a specific language.

```php
$googleTimeZone
   ->getTimeZoneForCoordinates('39.6034810', '-119.6822510');
   ->setLanguage('es');

/*
// Will return this array
[
    'dstOffset' : 0,
    'rawOffset' : -28800,
    'timeZoneId' : 'America/Los_Angeles',
    'timeZoneName' : 'Hora de verano del Pacífico'
]
*/
```

It is possible to specify a timestamp for the location so that daylight savings can be taken into account. We will set this timestamp to the current time by default.

```php
$googleTimeZone
   ->getTimeZoneForCoordinates('39.6034810', '-119.6822510');
   ->setTimestamp(new DateTime('03/15/2016 12:00'));

/*
// Will return this array
[
    'dstOffset' : 3600,
    'rawOffset' : -28800,
    'timeZoneId' : 'America/Los_Angeles',
    'timeZoneName' : 'Pacific Daylight Time'
]
*/
```


If you are using the package with Laravel, you can simply call `getTimeZoneForCoordinates `.

```php
GoogleTimeZone::getTimeZoneForCoordinates('39.6034810', '-119.6822510');

/*
// Will return this array
[
    'dstOffset' : 0,
    'rawOffset' : -28800,
    'timeZoneId' : 'America/Los_Angeles',
    'timeZoneName' : 'Pacific Standard Time'
]
*/
```

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Credits

- [Ruben Van Assche](https://github.com/rubenvanassche)
- [All Contributors](../../contributors)

## Support us

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

Does your business depend on our contributions? Reach out and support us on [Patreon](https://www.patreon.com/spatie).
All pledges will be dedicated to allocating workforce on maintenance and new awesome stuff.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
