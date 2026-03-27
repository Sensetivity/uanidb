<?php

namespace App\Enums;

enum StudioSortEnum: string
{
    case AnimeCount = 'anime_count';
    case Name = 'name';

    public function getLabel(): string
    {
        return match ($this) {
            self::AnimeCount => 'За кількістю аніме',
            self::Name => 'За алфавітом',
        };
    }
}
