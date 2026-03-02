<?php

namespace App\Enums;

enum AnimeRatingEnum: int
{
    case G = 1;
    case Pg = 2;
    case Pg13 = 3;
    case R = 4;
    case RPlus = 5;
    case Rx = 6;

    private const MAP = [
        'g' => self::G,
        'pg' => self::Pg,
        'pg-13' => self::Pg13,
        'r' => self::R,
        'r+' => self::RPlus,
        'rx' => self::Rx,
    ];

    /**
     * Parse MAL rating string (e.g. "PG-13 - Teens 13 or older") to enum.
     */
    public static function fromString(string $rating): ?self
    {
        $prefix = strtolower(explode(' - ', $rating)[0]);

        return self::MAP[$prefix] ?? null;
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::G => 'G',
            self::Pg => 'PG',
            self::Pg13 => 'PG-13',
            self::R => 'R',
            self::RPlus => 'R+',
            self::Rx => 'Rx',
        };
    }
}
