<?php

namespace App\Enums;

enum SeasonOfYearEnum: int
{
    case Winter = 1;
    case Spring = 2;
    case Summer = 3;
    case Fall = 4;

    private const MAP = [
        'winter' => self::Winter,
        'spring' => self::Spring,
        'summer' => self::Summer,
        'fall' => self::Fall,
    ];

    public static function fromString(string $season): ?self
    {
        return self::MAP[strtolower($season)] ?? null;
    }
}
