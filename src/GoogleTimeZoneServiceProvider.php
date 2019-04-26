<?php

namespace Spatie\GoogleTimeZone;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

final class GoogleTimeZoneServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/google-time-zone.php' => config_path('google-time-zone.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/google-time-zone.php', 'google-time-zone');

        $this->app->bind('google-time-zone', function ($app) {
            return (new GoogleTimeZone(new Client))
                ->setApiKey(config('google-time-zone.key'))
                ->setLanguage(config('google-time-zone.language', 'language'));

        });
    }
}
