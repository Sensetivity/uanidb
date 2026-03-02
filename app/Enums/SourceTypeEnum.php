<?php

namespace App\Enums;

enum SourceTypeEnum: int
{
    case ORIGINAL = 1;
    case MANGA = 2;
    case FOUR_KOMA_MANGA = 3;
    case WEB_MANGA = 4;
    case DIGITAL_MANGA = 5;
    case NOVEL = 6;
    case LIGHT_NOVEL = 7;
    case VISUAL_NOVEL = 8;
    case GAME = 9;
    case CARD_GAME = 10;
    case BOOK = 11;
    case PICTURE_BOOK = 12;
    case RADIO = 13;
    case MUSIC = 14;
    case WEB_NOVEL = 15;
    case MIXED_MEDIA = 16;
    case OTHER = 99;

    private const MAP = [
        'manga' => self::MANGA,
        'light novel' => self::LIGHT_NOVEL,
        'novel' => self::NOVEL,
        'original' => self::ORIGINAL,
        'game' => self::GAME,
        'visual novel' => self::VISUAL_NOVEL,
        'card game' => self::CARD_GAME,
        'book' => self::BOOK,
        'picture book' => self::PICTURE_BOOK,
        'radio' => self::RADIO,
        'music' => self::MUSIC,
        '4-koma manga' => self::FOUR_KOMA_MANGA,
        'web manga' => self::WEB_MANGA,
        'web novel' => self::WEB_NOVEL,
        'mixed media' => self::MIXED_MEDIA,
    ];

    public static function fromString(string $source): ?self
    {
        return self::MAP[strtolower($source)] ?? null;
    }
}
