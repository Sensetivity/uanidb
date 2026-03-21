<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum RankingCategoryEnum: string implements HasLabel
{
    case Movies = 'movies';
    case Ova = 'ova';
    case Popular = 'popular';
    case Top = 'top';

    public function getLabel(): string
    {
        return match ($this) {
            self::Top => 'Топ аніме',
            self::Popular => 'Найпопулярніші',
            self::Movies => 'Топ фільмів',
            self::Ova => 'Топ OVA',
        };
    }
}
