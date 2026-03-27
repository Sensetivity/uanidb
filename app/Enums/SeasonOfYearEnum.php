<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum SeasonOfYearEnum: int implements HasColor, HasLabel
{
    case Fall = 4;
    case Spring = 2;
    case Summer = 3;
    case Winter = 1;

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

    public function getColor(): string
    {
        return match ($this) {
            self::Winter => 'info',
            self::Spring => 'success',
            self::Summer => 'danger',
            self::Fall => 'warning',
        };
    }

    public function getEmoji(): string
    {
        return match ($this) {
            self::Winter => '❄️',
            self::Spring => '🌸',
            self::Summer => '☀️',
            self::Fall => '🍂',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::Winter => 'Зима',
            self::Spring => 'Весна',
            self::Summer => 'Літо',
            self::Fall => 'Осінь',
        };
    }
}
