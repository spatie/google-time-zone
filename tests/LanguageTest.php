<?php

namespace Spatie\GoogleTimeZone\Tests;

use PHPUnit\Framework\TestCase;
use Spatie\GoogleTimeZone\Language;
use Spatie\GoogleTimeZone\Exceptions\GoogleTimeZoneException;

class LanguageTest extends TestCase
{
    /** @test */
    public function it_will_return_default_language_when_not_specified()
    {
        $this->assertEquals(Language::ENGLISH, new Language());
    }

    /** @test */
    public function it_will_return_specified_language()
    {
        $this->assertEquals(Language::URDU, new Language(Language::URDU));
    }

    /** @test */
    public function it_will_return_all_supported_languages()
    {
        $this->assertEquals(82, count((new Language())->all()));
    }

    /** @test */
    public function it_will_except_when_trying_to_add_unsupported_language()
    {
        $this->expectException(GoogleTimeZoneException::class);
        $this->expectExceptionMessage('Unsupported google timezone language');

        new Language('invalid-language');
    }
}