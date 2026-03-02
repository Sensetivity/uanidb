<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AnimeStatusEnum: int implements HasColor, HasLabel
{
    case AIRING = 1;
    case FINISHED = 2;
    case NOT_YET_AIRED = 3;

    private const MAP = [
        'airing' => self::AIRING,
        'currently airing' => self::AIRING,
        'finished airing' => self::FINISHED,
        'complete' => self::FINISHED,
        'completed' => self::FINISHED,
        'not yet aired' => self::NOT_YET_AIRED,
        'upcoming' => self::NOT_YET_AIRED,
    ];

    public static function fromString(string $status): self
    {
        return self::MAP[strtolower($status)] ?? self::NOT_YET_AIRED;
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::AIRING => 'Airing',
            self::FINISHED => 'Finished',
            self::NOT_YET_AIRED => 'Not Yet Aired',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::AIRING => 'success',
            self::FINISHED => 'gray',
            self::NOT_YET_AIRED => 'warning',
        };
    }
}
