<?php

namespace Spatie\GoogleTimeZone\Tests;

use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Middleware;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Handler\MockHandler;
use Spatie\GoogleTimeZone\Exceptions\GoogleTimeZoneException;
use Spatie\GoogleTimeZone\GoogleTimeZone;
use Spatie\GoogleTimeZone\Exceptions\TimeZoneNotFound;

class GoogleTimeZoneTest extends TestCase
{
    /** @var \Spatie\GoogleTimeZone\GoogleTimeZone */
    private $googleTimeZone;

    /** @var array */
    private $historyContainer;

    public function setUp(): void
    {
        parent::setUp();

        $this->historyContainer = [];
    }

    /** @test */
    public function it_can_find_a_timezone_with_timestamp()
    {
        $client = $this->createFakeClient([
            new Response(200, [], json_encode([
                'dstOffset' => 3600,
                'rawOffset' => -18000,
                'status' => 'OK',
                'timeZoneId' => 'America/New_York',
                'timeZoneName' => 'Eastern Daylight Time',
            ])),
        ]);

        $googleTimezone = new GoogleTimeZone($client);

        $timezone = $googleTimezone->setApiKey('fake_api_key')
            ->setTimeStamp(new DateTime('03/15/2016 12:00'))
            ->getTimeZoneForCoordinates('38.908133', '-77.047119');

        $this->assertEquals(3600, $timezone['dstOffset']);
        $this->assertEquals(-18000, $timezone['rawOffset']);
        $this->assertEquals('America/New_York', $timezone['timeZoneId']);
        $this->assertEquals('Eastern Daylight Time', $timezone['timeZoneName']);
    }

    /** @test */
    public function it_can_find_a_timezone_without_timestamp()
    {
        $client = $this->createFakeClient([
            new Response(200, [], json_encode([
                'dstOffset' => 3600,
                'rawOffset' => -18000,
                'status' => 'OK',
                'timeZoneId' => 'America/New_York',
                'timeZoneName' => 'Eastern Daylight Time',
            ])),
        ]);

        $googleTimezone = new GoogleTimeZone($client);

        $timezone = $googleTimezone->setApiKey('fake_api_key')
            ->getTimeZoneForCoordinates('38.908133', '-77.047119');

        $this->assertEquals(3600, $timezone['dstOffset']);
        $this->assertEquals(-18000, $timezone['rawOffset']);
        $this->assertEquals('America/New_York', $timezone['timeZoneId']);
        $this->assertEquals('Eastern Daylight Time', $timezone['timeZoneName']);
    }

    /** @test */
    public function it_can_find_a_timezone_in_a_specified_language()
    {
        $client = $this->createFakeClient([
            new Response(200, [], json_encode([
                'dstOffset' => 3600,
                'rawOffset' => -28800,
                'status' => 'OK',
                'timeZoneId' => 'America/Los_Angeles',
                'timeZoneName' => 'Hora de verano del Pacífico',
            ])),
        ]);

        $googleTimezone = new GoogleTimeZone($client);

        $timezone = $googleTimezone->setApiKey('fake_api_key')
            ->setLanguage('es')
            ->getTimeZoneForCoordinates('38.908133', '-77.047119');

        $this->assertEquals(3600, $timezone['dstOffset']);
        $this->assertEquals(-28800, $timezone['rawOffset']);
        $this->assertEquals('America/Los_Angeles', $timezone['timeZoneId']);
        $this->assertEquals('Hora de verano del Pacífico', $timezone['timeZoneName']);
    }

    /** @test */
    public function it_creates_a_valid_request()
    {
        $client = $this->createFakeClient([
            new Response(200, [], json_encode([
                'dstOffset' => 3600,
                'rawOffset' => -18000,
                'status' => 'OK',
                'timeZoneId' => 'America/New_York',
                'timeZoneName' => 'Eastern Daylight Time',
            ])),
        ]);

        $googleTimezone = new GoogleTimeZone($client);

        $googleTimezone->setApiKey('fake_api_key')
            ->getTimeZoneForCoordinates('38.908133', '-77.047119');

        /** @var \GuzzleHttp\Psr7\Uri $requestUri */
        $requestUri = $this->historyContainer[0]['request']->getUri();

        $this->assertEquals('https', $requestUri->getScheme());
        $this->assertEquals('maps.googleapis.com', $requestUri->getHost());
        $this->assertEquals('/maps/api/timezone/json', $requestUri->getPath());
        $this->assertStringStartsWith('key=fake_api_key&location=38.908133%2C-77.047119&timestamp=', $requestUri->getQuery());
    }

    /** @test */
    public function it_creates_a_valid_request_with_language_and_timestamp()
    {
        $client = $this->createFakeClient([
            new Response(200, [], json_encode([
                'dstOffset' => 3600,
                'rawOffset' => -18000,
                'status' => 'OK',
                'timeZoneId' => 'America/New_York',
                'timeZoneName' => 'Eastern Daylight Time',
            ])),
        ]);

        $googleTimezone = new GoogleTimeZone($client);

        $googleTimezone->setApiKey('fake_api_key')
            ->setLanguage('es')
            ->setTimeStamp(new DateTime('03/15/2016 12:00'))
            ->getTimeZoneForCoordinates('38.908133', '-77.047119');

        /** @var \GuzzleHttp\Psr7\Uri $requestUri */
        $requestUri = $this->historyContainer[0]['request']->getUri();

        $this->assertEquals('key=fake_api_key&language=es&location=38.908133%2C-77.047119&timestamp=1458043200', $requestUri->getQuery());
    }

    /** @test */
    public function it_will_return_null_when_no_results_are_found()
    {
        $client = $this->createFakeClient([
            new Response(200, [], json_encode([
                'status' => 'ZERO_RESULTS',
            ])),
        ]);

        $googleTimezone = new GoogleTimeZone($client);

        $this->assertNull($googleTimezone->setApiKey('fake_api_key')->getTimeZoneForCoordinates('38.908133', '-77.047119'));
    }

    private function createFakeClient(array $responses)
    {
        $mock = new MockHandler($responses);

        $handler = HandlerStack::create($mock);

        $handler->push(Middleware::history($this->historyContainer));

        return new Client(['handler' => $handler]);
    }

    /** @test */
    public function it_will_except_when_status_code_is_other_then_200()
    {
        $this->expectException(GoogleTimeZoneException::class);

        $client = $this->createFakeClient([
            new Response(202, [], json_encode([
                'status' => 'UNKNOWN_ERROR',
            ])),
        ]);

        (new GoogleTimeZone($client))->getTimeZoneForCoordinates('38.908133', '-77.047119');
    }

    /** @test */
    public function it_will_except_when_there_is_a_error_message_in_response()
    {
        $this->expectException(GoogleTimeZoneException::class);

        $client = $this->createFakeClient([
            new Response(202, [], json_encode([
                'errorMessage' => 'some error message',
            ])),
        ]);

        (new GoogleTimeZone($client))->getTimeZoneForCoordinates('38.908133', '-77.047119');
    }
}
