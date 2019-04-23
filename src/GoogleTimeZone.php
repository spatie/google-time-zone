<?php

namespace Spatie\GoogleTimeZone;

use DateTime;
use DateTimeInterface;
use GuzzleHttp\Client;
use Spatie\GoogleTimeZone\Exceptions\GoogleTimeZoneException;

final class GoogleTimeZone
{
    /** @var \GuzzleHttp\Client */
    protected $client;

    /** @var string */
    protected $endpoint = 'https://maps.googleapis.com/maps/api/timezone/json';

    /** @var string */
    protected $apiKey;

    /** @var string */
    protected $language;

    /** @var DateTimeInterface|null */
    protected $timestamp;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function setApiKey(string $apiKey) : GoogleTimeZone
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    public function setTimestamp(DateTimeInterface $dateTime): GoogleTimeZone
    {
        $this->timestamp = $dateTime;

        return $this;
    }

    public function setLanguage(string $language): GoogleTimeZone
    {
        $this->language = $language;

        return $this;
    }

    public function getTimeZoneForCoordinates(
        string $latitude,
        string $longitude
    ): array {
        $payload = $this->getPayload($latitude, $longitude);

        $response = $this->client->get($this->endpoint, $payload);

        if ($response->getStatusCode() !== 200) {
            throw GoogleTimeZoneException::couldNotConnect();
        }

        $timezoneResponse = json_decode($response->getBody());

        if (! empty($timezoneResponse->errorMessage)) {
            throw GoogleTimeZoneException::serviceReturnedError($timezoneResponse->errorMessage);
        }

        return $this->formatResponse($timezoneResponse);
    }

    private function getPayload(string $latitude, string $longitude): array
    {
        $date = $this->timestamp ?? new DateTime();

        $parameters = [
            'key' => $this->apiKey,
            'language' => $this->language,
            'location' => "{$latitude},{$longitude}",
            'timestamp' => $date->getTimestamp(),
        ];

        return [
            'query' => $parameters,
        ];
    }

    private function formatResponse($timezoneResponse): array
    {
        return [
            'dstOffset' => $timezoneResponse->dstOffset,
            'rawOffset' => $timezoneResponse->rawOffset,
            'timeZoneId' => $timezoneResponse->timeZoneId,
            'timeZoneName' => $timezoneResponse->timeZoneName,
        ];
    }
}
