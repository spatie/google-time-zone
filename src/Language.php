<?php

namespace Spatie\GoogleTimeZone;

use Spatie\GoogleTimeZone\Exceptions\GoogleTimeZoneException;

final class Language
{
    /** @var string */
    const __DEFAULT = self::ENGLISH;
    /** @var string */
    public const ENGLISH = 'en';
    /** @var string */
    public const AFRIKAANS = 'af';
    /** @var string */
    public const ALBANIAN = 'sq';
    /** @var string */
    public const AMHARIC = 'am';
    /** @var string */
    /** @var string */
    public const ARABIC = 'ar';
    /** @var string */
    public const ARMENIAN = 'ar';
    /** @var string */
    public const AZERBAIJANI = 'az';
    /** @var string */
    public const BASQUE = 'eu';
    /** @var string */
    public const BELARUSIAN = 'be';
    /** @var string */
    public const BENGALI = 'bn';
    /** @var string */
    public const BOSNIAN = 'bs';
    /** @var string */
    public const BULGARIAN = 'bg';
    /** @var string */
    public const BURMESE = 'my';
    /** @var string */
    public const CATALAN = 'ca';
    /** @var string */
    public const CHINESE = 'zh';
    /** @var string */
    public const CHINESE_SIMPLIFIED = 'zh-CN';
    /** @var string */
    public const CHINESE_HONG_KONG = 'zh-HK';
    /** @var string */
    public const CHINESE_TRADITIONAL = 'zh-TW';
    /** @var string */
    public const CROATIAN = 'hr';
    /** @var string */
    public const CZECH = 'cs';
    /** @var string */
    public const DANISH = 'da';
    /** @var string */
    public const DUTCH = 'nl';
    /** @var string */
    public const ENGLISH_AUSTRALIAN = 'en-AU';
    /** @var string */
    public const ENGLISH_GREAT_BRITAIN = 'en-GB';
    /** @var string */
    public const ESTONIAN = 'et';
    /** @var string */
    public const FARSI = 'fa';
    /** @var string */
    public const FINNISH = 'fi';
    /** @var string */
    public const FILIPINO = 'fil';
    /** @var string */
    public const FRENCH = 'fr';
    /** @var string */
    public const FRENCH_CANADA = 'fr-CA';
    /** @var string */
    public const GALICIAN = 'gl';
    /** @var string */
    public const GEORGIAN = 'ka';
    /** @var string */
    public const GERMAN = 'de';
    /** @var string */
    public const GREEK = 'el';
    /** @var string */
    public const GUJARATI = 'gu';
    /** @var string */
    public const HEBREW = 'iw';
    /** @var string */
    public const HINDI = 'hi';
    /** @var string */
    public const HUNGARIAN = 'hu';
    /** @var string */
    public const ICELANDIC = 'is';
    /** @var string */
    public const INDONESIAN = 'id';
    /** @var string */
    public const ITALIAN = 'it';
    /** @var string */
    public const JAPANESE = 'ja';
    /** @var string */
    public const KANNADA = 'kn';
    /** @var string */
    public const KAZAKH = 'kk';
    /** @var string */
    public const KHMER = 'km';
    /** @var string */
    public const KOREAN = 'ko';
    /** @var string */
    public const KYRGYZ = 'ky';
    /** @var string */
    public const LAO = 'lo';
    /** @var string */
    public const LATVIAN = 'lv';
    /** @var string */
    public const LITHUANIAN = 'lt';
    /** @var string */
    public const MACEDONIAN = 'mk';
    /** @var string */
    public const MALAY = 'ms';
    /** @var string */
    public const MALAYALAM = 'ml';
    /** @var string */
    public const MARATHI = 'mr';
    /** @var string */
    public const MONGOLIAN = 'mn';
    /** @var string */
    public const NEPALI = 'ne';
    /** @var string */
    public const NORWEGIAN = 'no';
    /** @var string */
    public const Polish = 'pl';
    /** @var string */
    public const PORTUGUESE = 'pr';
    /** @var string */
    public const PORTUGUESE_BRAZIL = 'pt-BR';
    /** @var string */
    public const PORTUGUESE_PORTUGAL = 'pt-PT';
    /** @var string */
    public const PUNJABI = 'pa';
    /** @var string */
    public const ROMANIAN = 'ro';
    /** @var string */
    public const RUSSIAN = 'ru';
    /** @var string */
    public const SERBIAN = 'sr';
    /** @var string */
    public const SINHALESE = 'si';
    /** @var string */
    public const SLOVAK = 'sk';
    /** @var string */
    public const SLOVENIAN = 'sl';
    /** @var string */
    public const SPANISH = 'es';
    /** @var string */
    public const SPANISH_LATIN_AMERICA = 'es-419';
    /** @var string */
    public const SWAHILI = 'sw';
    /** @var string */
    public const SWEDISH = 'sv';
    /** @var string */
    public const TAMIL = 'ta';
    /** @var string */
    public const TELUGU = 'te';
    /** @var string */
    public const THAI = 'th';
    /** @var string */
    public const TURKISH = 'tr';
    /** @var string */
    public const UKRAINIAN = 'uk';
    /** @var string */
    public const URDU = 'ur';
    /** @var string */
    public const UZBEK = 'uz';
    /** @var string   */
    public const VIETNAMESE = 'vi';
    /** @var string */
    public const ZULU = 'zu';

    /** @var string */
    private $language;

    public function __construct(string $language = null)
    {
        if (! is_null($language) && ! in_array($language, $this->all(), true)) {
            throw GoogleTimeZoneException::unsupportedLanguage();
        }

        $this->language = $language ?? self::__DEFAULT;
    }

    public function __toString(): string
    {
        return $this->language;
    }

    public function all(): array
    {
        return (new \ReflectionClass(self::class))->getConstants();
    }
}
