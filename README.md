# Get the time zone used at the given coordinates

[![Latest Version](https://img.shields.io/github/release/spatie/google-time-zone.svg?style=flat-square)](https://github.com/spatie/google-time-zone/releases)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/spatie/google-time-zone/master.svg?style=flat-square)](https://travis-ci.org/spatie/google-time-zone)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/google-time-zone.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/google-time-zone)
[![StyleCI](https://github.styleci.io/repos/183008491/shield?branch=master)](https://github.styleci.io/repos/183008491)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/google-time-zone.svg?style=flat-square)](https://packagist.org/packages/spatie/google-time-zone)

This package can convert GPS coordinates to time zones using [Google's Time Zone service](https://developers.google.com/maps/documentation/timezone/intro). Here's a quick example:

```php
GoogleTimeZone::getTimeZoneForCoordinates('51.2194475', '4.4024643');

// Will return this array
[
    "dstOffset" => 0
    "rawOffset" => 3600
    "timeZoneId" => "Europe/Brussels"
    "timeZoneName" => "Central European Standard Time"
]
```

## Installation

You can install this package through composer.

```bash
composer require spatie/google-time-zone
```
## Laravel installation

Though the package works fine in non-Laravel projects we've included some niceties for our fellow Artisans.

In Laravel will autoregister the package itself, but you should still publish the config file yourself.

```bash
php artisan vendor:publish --provider="Spatie\GoogleTimeZone\GoogleTimeZoneServiceProvider" --tag="config"
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

Here's how you can get the time zone for a given set of coordinates.

```php
$googleTimeZone = new GoogleTimeZone();

$googleTimeZone->setApiKey(config('google-time-zone.key'));

$googleTimeZone->getTimeZoneForCoordinates('51.2194475', '4.4024643');

/*
// Will return this array
[
    "dstOffset" => 0
    "rawOffset" => 3600
    "timeZoneId" => "Europe/Brussels"
    "timeZoneName" => "Central European Standard Time"
]
*/
```

You can get the result back in a specific language.

```php
$googleTimeZone
   ->setLanguage('nl')
   ->getTimeZoneForCoordinates('51.2194475', '4.4024643');

/*
// Will return this array
[
      "dstOffset" => 0
      "rawOffset" => 3600
      "timeZoneId" => "Europe/Brussels"
      "timeZoneName" => "Midden-Europese standaardtijd"
]
*/
```

It is possible to specify a timestamp for the location so that daylight savings can be taken into account. We will set this timestamp to the current time by default.

```php
$googleTimeZone
   ->setTimestamp(new DateTime('13 august 2018'))
   ->getTimeZoneForCoordinates('51.2194475', '4.4024643');

/*
// Will return this array
[
      "dstOffset" => 3600
      "rawOffset" => 3600
      "timeZoneId" => "Europe/Brussels"
      "timeZoneName" => "Central European Summer Time"
]
*/
```

If you are using the package with Laravel, you can simply call `getTimeZoneForCoordinates`.

```php
GoogleTimeZone::getTimeZoneForCoordinates('51.2194475', '4.4024643');

/*
// Will return this array
[
    "dstOffset" => 0
    "rawOffset" => 3600
    "timeZoneId" => "Europe/Brussels"
    "timeZoneName" => "Central European Standard Time"
]
*/
```

When no time zone was found `null` will be returned.

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
