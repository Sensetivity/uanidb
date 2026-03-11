<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;

enum AnimeTypeEnum: int implements HasColor, HasIcon, HasLabel
{
    case MOVIE = 3;
    case MUSIC = 6;
    case ONA = 5;
    case OVA = 2;
    case SPECIAL = 4;
    case TV = 1;
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

    public function getIcon(): ?Heroicon
    {
        return match ($this) {
            self::TV => Heroicon::OutlinedTv,
            self::MOVIE => Heroicon::OutlinedFilm,
            self::OVA, self::ONA => Heroicon::OutlinedPlayCircle,
            self::MUSIC => Heroicon::OutlinedMusicalNote,
            self::SPECIAL => Heroicon::OutlinedSparkles,
            self::UNKNOWN => null,
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::TV => 'ТБ',
            self::OVA => 'OVA',
            self::MOVIE => 'Повнометражний',
            self::SPECIAL => 'Спешл',
            self::ONA => 'ONA',
            self::MUSIC => 'Кліп',
            self::UNKNOWN => 'Невідомо',
        };
    }
}
