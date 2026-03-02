<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AnimeTypeEnum: int implements HasColor, HasLabel
{
    case TV = 1;
    case OVA = 2;
    case MOVIE = 3;
    case SPECIAL = 4;
    case ONA = 5;
    case MUSIC = 6;
    case UNKNOWN = 99;

    private const MAP = [
        'tv' => AnimeTypeEnum::TV,
        'ova' => AnimeTypeEnum::OVA,
        'movie' => AnimeTypeEnum::MOVIE,
        'special' => AnimeTypeEnum::SPECIAL,
        'ona' => AnimeTypeEnum::ONA,
        'music' => AnimeTypeEnum::MUSIC,
    ];

    public static function fromString(string $relation): AnimeTypeEnum
    {
        return self::MAP[$relation] ?? self::UNKNOWN;
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::TV => 'TV',
            self::OVA => 'OVA',
            self::MOVIE => 'Movie',
            self::SPECIAL => 'Special',
            self::ONA => 'ONA',
            self::MUSIC => 'Music',
            self::UNKNOWN => 'Unknown',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::TV => 'indigo',
            self::MOVIE => 'blue',
            self::OVA => 'purple',
            self::ONA => 'purple',
            self::MUSIC => 'pink',
            self::SPECIAL => 'amber',
            self::UNKNOWN => 'gray',
        };
    }
}
