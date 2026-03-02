<?php

namespace App\Enums;

enum AnimeTitleLanguageEnum: string
{
    case Japanese = 'Japanese';
    case English = 'English';
    case German = 'German';
    case Spanish = 'Spanish';
    case French = 'French';
    case PortugueseBrazil = 'Portuguese (Brazil)';
    case Italian = 'Italian';
    case Chinese = 'Chinese';
    case Korean = 'Korean';
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
