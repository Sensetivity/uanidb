<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum EpisodeTypeEnum: int implements HasColor, HasLabel
{
    case Filler = 3;
    case Recap = 2;
    case Regular = 1;

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Regular => 'gray',
            self::Recap => 'warning',
            self::Filler => 'danger',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::Regular => 'Звичайний',
            self::Recap => 'Компіляція',
            self::Filler => 'Філер',
        };
    }
}
