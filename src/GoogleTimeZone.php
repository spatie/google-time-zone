<?php

namespace Spatie\GoogleTimeZone;

use DateTime;
use DateTimeInterface;
use GuzzleHttp\Client;
use Spatie\GoogleTimeZone\Exceptions\TimeZoneNotFound;
use Spatie\GoogleTimeZone\Exceptions\GoogleTimeZoneException;

final class GoogleTimeZone
{
    /** @var \GuzzleHttp\Client */
    private $client;

    /** @var string */
    private $endpoint = 'https://maps.googleapis.com/maps/api/timezone/json';

    /** @var string */
    private $apiKey;

    /** @var string */
    private $language;

    /** @var DateTimeInterface|null */
    private $timestamp;

    public function __construct(Client $client = null)
    {
        $this->client = $client ?? new Client();
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

    public function getTimeZoneForCoordinates(string $latitude, string $longitude): array
    {
        $payload = $this->getPayload($latitude, $longitude);

        $response = $this->client->get($this->endpoint, $payload);

        if ($response->getStatusCode() !== 200) {
            throw GoogleTimeZoneException::couldNotConnect();
        }

        $timezoneResponse = json_decode($response->getBody());

        if ($timezoneResponse->status === 'ZERO_RESULTS') {
            throw TimeZoneNotFound::forCoordinates($latitude, $longitude);
        }

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

    private function formatResponse(object $timezoneResponse): array
    {
        return [
            'dstOffset' => $timezoneResponse->dstOffset,
            'rawOffset' => $timezoneResponse->rawOffset,
            'timeZoneId' => $timezoneResponse->timeZoneId,
            'timeZoneName' => $timezoneResponse->timeZoneName,
        ];
    }
}
