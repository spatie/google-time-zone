<?php

namespace Spatie\GoogleTimeZone;

use DateTime;
use DateTimeInterface;
use GuzzleHttp\Client;
use Spatie\GoogleTimeZone\Exceptions\GoogleTimeZoneException;

class GoogleTimeZone
{
    /** @var \GuzzleHttp\Client */
    protected $client;

    /** @var string */
    protected $endpoint = 'https://maps.googleapis.com/maps/api/timezone/json';

    /** @var string */
    protected $apiKey;

    /** @var string */
    protected $language;

    /** @var \DateTimeInterface|null */
    protected $timestamp;

    public function __construct(?Client $client = null)
    {
        $this->client = $client ?? new Client;
    }

    public function setApiKey(string $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    public function setTimestamp(DateTimeInterface $dateTime): self
    {
        $this->timestamp = $dateTime;

        return $this;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getTimeZoneForCoordinates(string $latitude, string $longitude): ?array
    {
        $payload = $this->getPayload($latitude, $longitude);

        $response = $this->client->get($this->endpoint, $payload);

        if ($response->getStatusCode() !== 200) {
            throw GoogleTimeZoneException::couldNotConnect();
        }

        $timezoneResponse = json_decode($response->getBody());

        if (! empty($timezoneResponse->errorMessage)) {
            throw GoogleTimeZoneException::serviceReturnedError($timezoneResponse->errorMessage);
        }

        if ($timezoneResponse->status === 'ZERO_RESULTS') {
            return null;
        }

        return $this->formatResponse($timezoneResponse);
    }

    protected function getPayload(string $latitude, string $longitude): array
    {
        $date = $this->timestamp ?? new DateTime;

        return [
            'base_url' => '',
            'query' => [
                'key' => $this->apiKey,
                'language' => $this->language,
                'location' => "{$latitude},{$longitude}",
                'timestamp' => $date->getTimestamp(),
            ],
        ];
    }

    protected function formatResponse(object $timezoneResponse): array
    {
        return [
            'dstOffset' => $timezoneResponse->dstOffset,
            'rawOffset' => $timezoneResponse->rawOffset,
            'timeZoneId' => $timezoneResponse->timeZoneId,
            'timeZoneName' => $timezoneResponse->timeZoneName,
        ];
    }
}
