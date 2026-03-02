<?php

namespace App\Enums;

enum AnimeTitleLanguageEnum: string
{
    case Chinese = 'Chinese';
    case English = 'English';
    case French = 'French';
    case German = 'German';
    case Italian = 'Italian';
    case Japanese = 'Japanese';
    case Korean = 'Korean';
    case PortugueseBrazil = 'Portuguese (Brazil)';
    case Spanish = 'Spanish';
    case Ukrainian = 'Ukrainian';

    private const MAP = [
        'japanese' => self::Japanese,
        'english' => self::English,
        'german' => self::German,
        'spanish' => self::Spanish,
        'french' => self::French,
        'portuguese (brazil)' => self::PortugueseBrazil,
        'italian' => self::Italian,
        'chinese' => self::Chinese,
        'korean' => self::Korean,
        'ukrainian' => self::Ukrainian,
    ];

    public static function fromString(string $type): ?self
    {
        return self::MAP[strtolower($type)] ?? null;
    }

    public function toIsoCode(): string
    {
        return match ($this) {
            self::Japanese => 'ja',
            self::English => 'en',
            self::German => 'de',
            self::Spanish => 'es',
            self::French => 'fr',
            self::PortugueseBrazil => 'pt-br',
            self::Italian => 'it',
            self::Chinese => 'zh',
            self::Korean => 'ko',
            self::Ukrainian => 'uk',
        };
    }
}
